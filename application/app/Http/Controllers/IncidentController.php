<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;

class IncidentController extends Controller
{
    public function getAllIncidents() {
        $incidents = Incident::all();

        return response()->json([
            "status" => true,
            "message" => "Incidents data",
            "incidents" => $incidents
        ]);
    }

    public function newIncident(Request $request) {
        $request->validate([
            "name" => "required",
            "evidence" => "required",
            "criticality" => "required",
            "host" => "required"
        ]);

        Incident::create([
            "name" => $request->name,
            "evidence" => $request->evidence,
            "criticality" => $request->criticality,
            "host" => $request->host,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Incident created successfully"
        ]);
    }

    public function getIncidentByID($id){
        $incident = Incident::find($id);

        return response()->json([
            "status" => true,
            "message" => "Incident data",
            "incident" => $incident
        ]);
    }

    public function updateIncident(Request $request, $id){
        $incident = Incident::find($id);

        if (!$incident) {
            return response()->json([
                "status" => false,
                "message" => "Incident not found"
            ], 404);
        }

        $incident->update($request->only(['name', 'evidence', 'criticality', 'host']));

        return response()->json([
            "status" => true,
            "message" => "Incident updated successfully"
        ]);
    }

    public function deleteIncident($id) {
        $incident = Incident::find($id);

        if (!$incident) {
            return response()->json([
                "status" => false,
                "message" => "Incident not found"
            ], 404);
        }

        $incident->delete();

        return response()->json([
            "status" => true,
            "message" => "Incident deleted successfully"
        ]);
    }
}
