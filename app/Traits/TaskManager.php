<?php

namespace App\Traits;

use App\Enums\RepetetionTypeEnum;
use App\Enums\TaskTypeEnum;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait TaskManager
{
    public static function today(): Collection
    {
        $userId = Auth::user()->id;

        return self::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('repetetion_type', RepetetionTypeEnum::daily->value)
                    ->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where('task_type', TaskTypeEnum::dates->value)
                                ->where('to_date', '>=', today());
                        })
                            ->orWhere(function ($query) {
                                $query->where('task_type', TaskTypeEnum::repetetions->value)
                                    ->whereRaw('repetetions_count >= timestampdiff(DAY, created_at, now())');
                            });
                    })
                    ->orWhere(function ($query) {
                        $query->where('repetetion_type', RepetetionTypeEnum::weekly->value)
                            ->whereHas('repetetions', function ($query) {
                                $query->where('day', today()->dayOfWeek);
                            })
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where('task_type', TaskTypeEnum::dates->value)
                                        ->where('to_date', '>=', today());
                                })
                                    ->orWhere(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::repetetions->value)
                                            ->whereRaw('repetetions_count >= timestampdiff(WEEK, created_at, now())');
                                    });
                            });
                    })
                    ->orWhere(function ($query) {
                        $query->where('repetetion_type', RepetetionTypeEnum::monthly->value)
                            ->whereHas('repetetions', function ($query) {
                                $query->where('day', today()->day);
                            })
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where('task_type', TaskTypeEnum::dates->value)
                                        ->where('to_date', '>=', today());
                                })
                                    ->orWhere(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::repetetions->value)
                                            ->whereRaw('repetetions_count >= timestampdiff(MONTH, created_at, now())');
                                    });
                            });
                    })
                    ->orWhere(function ($query) {
                        $query->where('repetetion_type', RepetetionTypeEnum::yearly->value)
                            ->whereHas('repetetions', function ($query) {
                                $query->where('day', today()->day)
                                    ->where('month', today()->month);
                            })
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where('task_type', TaskTypeEnum::dates->value)
                                        ->where('to_date', '>=', today());
                                })
                                    ->orWhere(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::repetetions->value)
                                            ->whereRaw('repetetions_count >= timestampdiff(YEAR, created_at, now())');
                                    });
                            });
                    });
            })
            ->with('group')
            ->get();
    }

    public static function tomorrow(): Collection
    {
        $userId = Auth::user()->id;

        return self::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('repetetion_type', RepetetionTypeEnum::daily->value)
                    ->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where('task_type', TaskTypeEnum::dates->value)
                                ->where('to_date', '>=', today()->addDay());
                        })
                            ->orWhere(function ($query) {
                                $query->where('task_type', TaskTypeEnum::repetetions->value)
                                    ->whereRaw('repetetions_count >= timestampdiff(DAY, created_at, now() + INTERVAL 1 DAY)');
                            });
                    })
                    ->orWhere(function ($query) {
                        $query->where('repetetion_type', RepetetionTypeEnum::weekly->value)
                            ->whereHas('repetetions', function ($query) {
                                $query->where('day', today()->addDay()->dayOfWeek);
                            })
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where('task_type', TaskTypeEnum::dates->value)
                                        ->where('to_date', '>=', today()->addDay());
                                })
                                    ->orWhere(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::repetetions->value)
                                            ->whereRaw('repetetions_count >= timestampdiff(WEEK, created_at, now() + INTERVAL 1 DAY)');
                                    });
                            });
                    })
                    ->orWhere(function ($query) {
                        $query->where('repetetion_type', RepetetionTypeEnum::monthly->value)
                            ->whereHas('repetetions', function ($query) {
                                $query->where('day', today()->addDay()->day);
                            })
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where('task_type', TaskTypeEnum::dates->value)
                                        ->where('to_date', '>=', today()->addDay());
                                })
                                    ->orWhere(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::repetetions->value)
                                            ->whereRaw('repetetions_count >= timestampdiff(MONTH, created_at, now() + INTERVAL 1 DAY)');
                                    });
                            });
                    })
                    ->orWhere(function ($query) {
                        $query->where('repetetion_type', RepetetionTypeEnum::yearly->value)
                            ->whereHas('repetetions', function ($query) {
                                $query->where('day', today()->addDay()->day)
                                    ->where('month', today()->addDay()->month);
                            })
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where('task_type', TaskTypeEnum::dates->value)
                                        ->where('to_date', '>=', today()->addDay());
                                })
                                    ->orWhere(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::repetetions->value)
                                            ->whereRaw('repetetions_count >= timestampdiff(YEAR, created_at, now() + INTERVAL 1 DAY)');
                                    });
                            });
                    });
            })
            ->with('group')
            ->get();
    }

    public static function nextWeek(): Collection
    {
        $userId = Auth::user()->id;

        $dates = CarbonPeriod::create(today()->addWeek()->startOfWeek(), today()->addWeek()->endOfWeek())->toArray();
        $days = [];
        $months = [];
        foreach ($dates as $date) {
            $days[] = $date->day;
            if (!in_array($date->month, $months, true)) {
                array_push($months, $date->month);
            }
        }

        return self::where('user_id', $userId)
            ->where(function ($query) use ($days, $months) {
                $query->where(function ($query) {
                    $query->where('repetetion_type', RepetetionTypeEnum::daily->value)
                        ->orWhere('repetetion_type', RepetetionTypeEnum::weekly->value)
                        ->where(function ($query) {
                            $query->where(function ($query) {
                                $query->where('task_type', TaskTypeEnum::dates->value)
                                    ->whereBetween('to_date', [today()->addWeek()->startOfWeek(), today()->addWeek()->endOfWeek()]);
                            })
                                ->orWhere(function ($query) {
                                    $query->where('task_type', TaskTypeEnum::repetetions->value)
                                        ->whereRaw('repetetions_count >= timestampdiff(DAY, created_at, now() + INTERVAL 7 - weekday(now()) DAY)');
                                });
                        });
                })
                    ->orWhere(function ($query) use ($days, $months) {
                        $query->where('repetetion_type', RepetetionTypeEnum::monthly->value)
                            ->where(function ($query) use ($days, $months) {
                                $query->whereHas('repetetions', function ($query) use ($days, $months) {
                                    $query->whereIn('day', $days);
                                });
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::dates->value)
                                            ->whereBetween('to_date', [today()->addWeek()->startOfWeek(), today()->addWeek()->endOfWeek()]);
                                    })
                                        ->orWhere(function ($query) {
                                            $query->where('task_type', TaskTypeEnum::repetetions->value)
                                                ->whereRaw('repetetions_count >= timestampdiff(MONTH, created_at, now() + INTERVAL 7 - weekday(now()) DAY)');
                                        });
                                });
                            });
                    })
                    ->orWhere(function ($query) use ($days, $months) {
                        $query->where('repetetion_type', RepetetionTypeEnum::yearly->value)
                            ->where(function ($query) use ($days, $months) {
                                $query->whereHas('repetetions', function ($query) use ($days, $months) {
                                    $query->whereIn('day', $days)
                                        ->whereIn('month', $months);
                                });
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::dates->value)
                                            ->whereBetween('to_date', [today()->addWeek()->startOfWeek(), today()->addWeek()->endOfWeek()]);
                                    })
                                        ->orWhere(function ($query) {
                                            $query->where('task_type', TaskTypeEnum::repetetions->value)
                                                ->whereRaw('repetetions_count >= timestampdiff(YEAR, created_at, now() + INTERVAL 7 - weekday(now()) DAY)');
                                        });
                                });
                            });
                    });
            })
            ->with('group')
            ->get();
    }

    public static function nearFuture(): Collection
    {
        $userId = Auth::user()->id;
        $secondWeekDay = today()->addWeeks(2)->startOfWeek();

        $dates = CarbonPeriod::create(clone $secondWeekDay, clone $secondWeekDay->endOfWeek())->toArray();
        $days = [];
        $months = [];
        foreach ($dates as $date) {
            $days[] = $date->day;
            if (!in_array($date->month, $months, true)) {
                array_push($months, $date->month);
            }
        }

        return self::where('user_id', $userId)
            ->where(function ($query) use ($days, $months) {
                $query->where(function ($query) {
                    $query->where('repetetion_type', RepetetionTypeEnum::daily->value)
                        ->where(function ($query) {
                            $query->where('task_type', TaskTypeEnum::dates->value)
                                ->whereBetween('to_date', [today()->addWeeks(2)->startOfWeek(), today()->addWeeks(2)->endOfWeek()]);
                        })
                        ->orWhere(function ($query) {
                            $query->where('task_type', TaskTypeEnum::repetetions->value)
                                ->whereRaw('repetetions_count >= timestampdiff(DAY, created_at, now() + INTERVAL 14 - weekday(now()) DAY)');
                        });
                })
                    ->orWhere(function ($query) {
                        $query->orWhere('repetetion_type', RepetetionTypeEnum::weekly->value)
                            ->where(function ($query) {
                                $query->where('task_type', TaskTypeEnum::dates->value)
                                    ->whereBetween('to_date', [today()->addWeeks(2)->startOfWeek(), today()->addWeeks(2)->endOfWeek()]);
                            })
                            ->orWhere(function ($query) {
                                $query->where('task_type', TaskTypeEnum::repetetions->value)
                                    ->whereRaw('repetetions_count >= timestampdiff(WEEK, created_at, now() + INTERVAL 14 - weekday(now()) DAY)');
                            });
                    })
                    ->orWhere(function ($query) use ($days, $months) {
                        $query->where('repetetion_type', RepetetionTypeEnum::monthly->value)
                            ->where(function ($query) use ($days, $months) {
                                $query->whereHas('repetetions', function ($query) use ($days, $months) {
                                    $query->whereIn('day', $days);
                                });
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::dates->value)
                                            ->whereBetween('to_date', [today()->addWeeks(2)->startOfWeek(), today()->addWeeks(2)->endOfWeek()]);
                                    })
                                        ->orWhere(function ($query) {
                                            $query->where('task_type', TaskTypeEnum::repetetions->value)
                                                ->whereRaw('repetetions_count >= timestampdiff(MONTH, created_at, now() + INTERVAL 14 - weekday(now()) DAY)');
                                        });
                                });
                            });
                    })
                    ->orWhere(function ($query) use ($days, $months) {
                        $query->where('repetetion_type', RepetetionTypeEnum::yearly->value)
                            ->where(function ($query) use ($days, $months) {
                                $query->whereHas('repetetions', function ($query) use ($days, $months) {
                                    $query->whereIn('day', $days)
                                        ->whereIn('month', $months);
                                });
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::dates->value)
                                            ->whereBetween('to_date', [today()->addWeeks(2)->startOfWeek(), today()->addWeeks(2)->endOfWeek()]);
                                    })
                                        ->orWhere(function ($query) {
                                            $query->where('task_type', TaskTypeEnum::repetetions->value)
                                                ->whereRaw('repetetions_count >= timestampdiff(YEAR, created_at, now() + INTERVAL 14 - weekday(now()) DAY)');
                                        });
                                });
                            });
                    });
            })
            ->with('group')
            ->get();
    }

    public static function future(): Collection
    {
        $userId = Auth::user()->id;
        $secondWeekDay = today()->addWeeks(2)->startOfWeek();

        $dates = CarbonPeriod::create(clone $secondWeekDay, clone $secondWeekDay->endOfWeek())->toArray();
        $days = [];
        $months = [];
        foreach ($dates as $date) {
            $days[] = $date->day;
            if (!in_array($date->month, $months, true)) {
                array_push($months, $date->month);
            }
        }

        return self::where('user_id', $userId)
            ->where(function ($query) use ($days, $months) {
                $query->where(function ($query) {
                    $query->where('repetetion_type', RepetetionTypeEnum::daily->value)
                        ->where(function ($query) {
                            $query->where('task_type', TaskTypeEnum::dates->value)
                                ->whereDate('to_date', '>', today()->addWeeks(2)->endOfWeek());
                        })
                        ->orWhere(function ($query) {
                            $query->where('task_type', TaskTypeEnum::repetetions->value)
                                ->whereRaw('repetetions_count > timestampdiff(DAY, created_at, now() + INTERVAL 14 - weekday(now()) DAY)');
                        });
                })
                    ->orWhere(function ($query) {
                        $query->orWhere('repetetion_type', RepetetionTypeEnum::weekly->value)
                            ->where(function ($query) {
                                $query->where('task_type', TaskTypeEnum::dates->value)
                                    ->whereDate('to_date', '>', today()->addWeeks(2)->endOfWeek());
                            })
                            ->orWhere(function ($query) {
                                $query->where('task_type', TaskTypeEnum::repetetions->value)
                                    ->whereRaw('repetetions_count > timestampdiff(WEEK, created_at, now() + INTERVAL 14 - weekday(now()) DAY)');
                            });
                    })
                    ->orWhere(function ($query) {
                        $query->where('repetetion_type', RepetetionTypeEnum::monthly->value)
                            ->where(function ($query) {
                                $query->whereHas('repetetions', function ($query) {
                                    $query->whereBetween('day', [today()->addWeeks(2)->startOfWeek()->day, today()->addWeeks(2)->endOfWeek()->day]);
                                });
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::dates->value)
                                            ->whereDate('to_date', '>', today()->addWeeks(2)->endOfWeek());
                                    })
                                        ->orWhere(function ($query) {
                                            $query->where('task_type', TaskTypeEnum::repetetions->value)
                                                ->whereRaw('repetetions_count > timestampdiff(MONTH, created_at, now() + INTERVAL 14 - weekday(now()) DAY)');
                                        });
                                });
                            });
                    })
                    ->orWhere(function ($query) use ($days, $months) {
                        $query->where('repetetion_type', RepetetionTypeEnum::yearly->value)
                            ->where(function ($query) use ($days, $months) {
                                $query->whereHas('repetetions', function ($query) use ($days, $months) {
                                    $query->whereIn('day', $days)
                                        ->whereIn('month', $months);
                                });
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('task_type', TaskTypeEnum::dates->value)
                                            ->whereDate('to_date', '>', today()->addWeeks(2)->endOfWeek());
                                    })
                                        ->orWhere(function ($query) {
                                            $query->where('task_type', TaskTypeEnum::repetetions->value)
                                                ->whereRaw('repetetions_count > timestampdiff(YEAR, created_at, now() + INTERVAL 14 - weekday(now()) DAY)');
                                        });
                                });
                            });
                    });
            })
            ->with('group')
            ->get();
    }
}
