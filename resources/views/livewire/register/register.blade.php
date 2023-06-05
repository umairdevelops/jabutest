<form id="register-form">
 <div class=" flex items-center justify-center h-screen">
    <div class="w-1/2">
        <x-card title="Enter your credentials below">
            <x-errors class="mb-4" />

                <input label="Email" name='email'/>
         
            <div class="col-span-1 sm:col-span-2 gap-6">
                <input name="password" label="Password" value="" />
            </div>

            <x-slot name="footer">
                <button type="submit" value="Register authenticator" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Button
                  </button>
            </x-slot>
        </x-card>
    </div>
</div> 
  
</form>

<!-- Registering credentials -->
@push('scripts')
<script>
        class WebAuthn {
 
 #routes = {
     registerOptions: "webauthn/register/options",
     register: "webauthn/register",
     loginOptions: "webauthn/login/options",
     login: "webauthn/login",
 }

 #headers = {
     "Accept": "application/json",
     "Content-Type": "application/json",
     "X-Requested-With": "XMLHttpRequest"
 };

 #includeCredentials = false

 constructor(routes = {}, headers = {}, includeCredentials = false, xcsrfToken = null) {
     Object.assign(this.#routes, routes);
     Object.assign(this.#headers, headers);

     this.#includeCredentials = includeCredentials;

     let xsrfToken;
     let csrfToken;

     if (xcsrfToken === null) {
         // If the developer didn't issue an XSRF token, we will find it ourselves.
         xsrfToken = WebAuthn.#XsrfToken;
         csrfToken = WebAuthn.#firstInputWithCsrfToken;
     } else{
         // Check if it is a CSRF or XSRF token
         if (xcsrfToken.length === 40) {
             csrfToken = xcsrfToken;
         } else if (xcsrfToken.length === 224) {
             xsrfToken = xcsrfToken;
         } else {
             throw new TypeError('CSRF token or XSRF token provided does not match requirements. Must be 40 or 224 characters.');
         }
     }

     if (xsrfToken !== null) {
         this.#headers["X-XSRF-TOKEN"] ??= xsrfToken;
     } else if (csrfToken !== null) {
         this.#headers["X-CSRF-TOKEN"] ??= csrfToken;
     } else {
         // We didn't find it, and since is required, we will bail out.
         throw new TypeError('Ensure a CSRF/XSRF token is manually set, or provided in a cookie "XSRF-TOKEN" or or there is meta tag named "csrf-token".');
     }
 }

 static get #firstInputWithCsrfToken() {
     // First, try finding an CSRF Token in the head.
     let token = Array.from(document.head.getElementsByTagName("meta"))
         .find(element => element.name === "csrf-token");

     if (token) {
         return token.content;
     }

     // Then, try to find a hidden input containing the CSRF token.
     token = Array.from(document.getElementsByTagName('input'))
         .find(input => input.name === "_token" && input.type === "hidden")

     if (token) {
         return token.value;
     }

     return null;
 }

  static get #XsrfToken() {
     const cookie = document.cookie.split(";").find((row) => /^\s*(X-)?[XC]SRF-TOKEN\s*=/.test(row));

     return cookie ? cookie.split("=")[1].trim().replaceAll("%3D", "") : null;
 };


 #fetch(data, route, headers = {}) {
     const url = new URL(route, window.location.origin).href;
     
     return fetch(url, {
         method: "POST",
         credentials: this.#includeCredentials ? "include" : "same-origin",
         redirect: "error",
         headers: {...this.#headers, ...headers},
         body: JSON.stringify(data)
     });
 }

 static #base64UrlDecode(input) {
     input = input.replace(/-/g, "+").replace(/_/g, "/");

     const pad = input.length % 4;

     if (pad) {
         if (pad === 1) {
             throw new Error("InvalidLengthError: Input base64url string is the wrong length to determine padding");
         }

         input += new Array(5 - pad).join("=");
     }

     return atob(input);
 }


 static #uint8Array(input, useAtob = false) {
     return Uint8Array.from(
         useAtob ? atob(input) : WebAuthn.#base64UrlDecode(input), c => c.charCodeAt(0)
     );
 }

 static #arrayToBase64String(arrayBuffer) {
     return btoa(String.fromCharCode(...new Uint8Array(arrayBuffer)));
 }


 #parseIncomingServerOptions(publicKey) {
     console.debug(publicKey);

     publicKey.challenge = WebAuthn.#uint8Array(publicKey.challenge);

     if ('user' in publicKey) {
         publicKey.user = {
             ...publicKey.user,
             id: WebAuthn.#uint8Array(publicKey.user.id)
         };
     }

     [
         "excludeCredentials",
         "allowCredentials"
     ]
         .filter(key => key in publicKey)
         .forEach(key => {
             publicKey[key] = publicKey[key].map(data => {
                 return {...data, id: WebAuthn.#uint8Array(data.id)};
             });
         });

     console.log(publicKey);

     return publicKey;
 }


 #parseOutgoingCredentials(credentials) {
     let parseCredentials = {
         id: credentials.id,
         type: credentials.type,
         rawId: WebAuthn.#arrayToBase64String(credentials.rawId),
         response: {}
     };

     [
         "clientDataJSON",
         "attestationObject",
         "authenticatorData",
         "signature",
         "userHandle"
     ]
         .filter(key => key in credentials.response)
         .forEach(key => parseCredentials.response[key] = WebAuthn.#arrayToBase64String(credentials.response[key]));

     return parseCredentials;
 }

 static #handleResponse(response) {
     if (!response.ok) {
         throw response;
     }

     // Here we will do a small trick. Since most of the responses from the server
     // are JSON, we will automatically parse the JSON body from the response. If
     // it's not JSON, we will push the body verbatim and let the dev handle it.
     return new Promise((resolve) => {
         response
             .json()
             .then((json) => resolve(json))
             .catch(() => resolve(response.body));
     });
 }

 async register(request = {}, response = {}) {
    console.log(request);
     const optionsResponse = await this.#fetch(request, this.#routes.registerOptions);
     const json = await optionsResponse.json();
     const publicKey = this.#parseIncomingServerOptions(json);
     const credentials = await navigator.credentials.create({publicKey});
     const publicKeyCredential = this.#parseOutgoingCredentials(credentials);

     Object.assign(publicKeyCredential, response);
     Object.assign(publicKeyCredential, request);

     return await this.#fetch(publicKeyCredential, this.#routes.register).then(WebAuthn.#handleResponse);
 }


 async login(request = {}, response = {}) {
     const optionsResponse = await this.#fetch(request, this.#routes.loginOptions);
     const json = await optionsResponse.json();
     const publicKey = this.#parseIncomingServerOptions(json);
     const credentials = await navigator.credentials.get({publicKey});
     const publicKeyCredential = this.#parseOutgoingCredentials(credentials);

     Object.assign(publicKeyCredential, response);

     console.log(publicKeyCredential);

     return await this.#fetch(publicKeyCredential, this.#routes.login, response).then(WebAuthn.#handleResponse);
 }

 static supportsWebAuthn() {
     return typeof PublicKeyCredential != "undefined";
 }

 static doesntSupportWebAuthn() {
     return !this.supportsWebAuthn();
 }
}
    const register = event => {
        event.preventDefault()
        
        new WebAuthn().register()
          .then(response => alert('Registration successful!'))
          .catch(error => alert('Something went wrong, try again!'))
    }

    document.getElementById('register-form').addEventListener('submit', register)
</script>
@endpush
