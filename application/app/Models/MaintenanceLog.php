<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class MaintenanceLog extends Model
{
    protected $fillable = ['type', 'bike_id', 'component', 'note', 'grease_monkey', 'distance_id', 'work_done_at'];

    use SoftDeletes;

    static function getLogsAndRelated($userId)
    {
        return DB::table('maintenance_logs')
            ->join('bikes', 'maintenance_logs.bike_id', '=', 'bikes.id')
            ->join('distances', 'maintenance_logs.distance_id', '=', 'distances.id')
            ->select('maintenance_logs.*', 'bikes.name as bike_name', 'distances.metric', 'distances.imperial')
            ->where('bikes.user_id', $userId)
            ->where('maintenance_logs.deleted_at', NULL)
            ->orderBy('maintenance_logs.work_done_at', 'desc')
            ->get();

    }
}
