Project Code Features:

1. **TaskGroup Component (TaskGroup.php):**
- This component is used for managing task groups.
- It is responsible for creating and storing new task groups.
- It defines public properties to hold the form data for the task group, such as 'name' and 'description'.
- It implements wire events like `save()` and `cancel()` to handle form submission and resetting.
- The `render()` method returns the view associated with this component.

2. **GroupTable Component (GroupTable.php):**
- This component displays a table of task groups.
- It retrieves all task groups from the database and assigns them to the `$taskGroups` property.
- The `render()` method returns the view associated with this component.

3. **Login Component (Login.php):**
- This component handles the login functionality.
- It defines public properties for 'email' and 'password' fields.
- It includes validation rules for these properties.
- The `login()` method is triggered when the form is submitted.
- It validates the form inputs, attempts authentication, and redirects on successful login.
- The `render()` method returns the view associated with this component.

4. **CreateTask Component (CreateTask.php):**
- This component allows users to create new tasks.
- It initializes various properties for form fields, such as 'repetetionTypeList', 'weekDaysList', 'monthsList', 'monthDaysList', and 'groupsList'.
- The `mount()` method sets the default values for some properties.
- It defines a `save()` method to handle form submission and create a new task in the database based on the provided inputs.
- The component includes custom validation logic in the `customValidate()` method.
- The `resetForm()` method resets all form fields to their default values.
- The `render()` method returns the view associated with this component.

5. **TaskList Component (TaskList.php):**
- This component displays a list of tasks based on different criteria.
- It defines properties for task lists categorized by 'activeTab', 'todayTasks', 'tomorrowTasks', 'nextWeekTasks', 'nearFutureTasks', and 'futureTasks'.
- The `mount()` method retrieves tasks from the database based on different time frames and assigns them to the respective properties.
- It defines methods for marking tasks as complete or incomplete, which update the corresponding task in the database.
- The `render()` method returns the view associated with this component, passing the relevant task list based on the active tab.

6. **Web Routes (web.php):**
- This file contains the route definitions for the web application.
- The '/login' route maps to the `Login` component.
- The '/logout' route is associated with the 'logout' method of the `AuthController`.
- Routes inside the 'auth' middleware group require authentication to access.
- The '/' route maps to the `TaskGroup` component.
- The '/groups' route maps to the `GroupTable` component.
- The '/create/task' route maps to the `CreateTask` component.
- The '/tasks' route maps to the `TaskList` component.

7. **TaskManager Trait (TaskManager.php):**
- This trait provides task management functionality.
- It defines static methods like 'today()', 'tomorrow()', 'nextWeek()', 'nearFuture()', and 'future()' that return collections of tasks based on different time frames.

8. **Public Routes:**
- '/login': This route is public and accessible without authentication. It renders the login form using the `Login` component.
- '/logout': This route is public and accessible without authentication. It triggers the 'logout' method of the `AuthController`.

9. **Protected Routes (Middleware Auth):**
- '/': This route is protected and requires authentication. It renders the `TaskGroup` component, which manages task groups.
- '/groups': This route is protected and requires authentication. It renders the `GroupTable` component, which displays a table of task groups.
- '/create/task': This route is protected and requires authentication. It renders the `CreateTask` component, allowing users to create new tasks.
- '/tasks': This route is protected and requires authentication. It renders the `TaskList` component, displaying different task lists based on the active tab.

10. **Key Features:**
- User authentication and login functionality.
- CRUD operations for task groups.
- Creation of new tasks with various options for repetition and date selection.
- Displaying and managing tasks based on different time frames.
- Relationship between tasks, task groups, and repetitions.
- Form validation and error handling.
- Integration with Laravel Eloquent ORM for database operations.
- Component-based architecture using Livewire for interactive UI.

11. **Live Testing:**
- Open the following URL.
- Email/Username : `user@mail.com`
- Password : `password`
- Use the Task Manager with ❤️ Love
