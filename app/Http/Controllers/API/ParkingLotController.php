<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Parking;
use App\Models\Lot;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ParkingLotController extends Controller
{
    public $successStatus = 200;
    public $PARKING_RATE = 2; //per minute

    public function getLotStatus()
    {
        $lot = Lot::all();

        return response()->json(['Parking Lot Status' => $lot], $this->successStatus);
    }

    public function addVehicle(Request $request)
    {
        $requestData = $request->all();
        $requestData['status'] = 0;

        $vehicle = Vehicle::create($requestData);

        return response()->json(['Vehicle Added Successfully' => $vehicle], $this->successStatus);
    }

    public function getVehicle()
    {

        $vehicle = Vehicle::all();

        return response()->json(['Vehicle List' => $vehicle], $this->successStatus);
    }

    public function getVehicleById($id)
    {

        $vehicle = Vehicle::where('id', $id)->get();

        return response()->json(['Vehicle' => $vehicle], $this->successStatus);
    }

    public function parkVehicle($vehicleId, $lotId)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);

        if($vehicle !== null)
        {
            if($vehicle->status === 0)
            {
                $lotArr = Lot::where('category', $vehicle->category)->where('status', 0)->get(['id', 'category']);

                if($lotArr !== null)
                {
                    $lot = Lot::where('category', $vehicle->category)->where('id', $lotId)->where('status', 0)->first();
                    if($lot !== null)
                    {
                        Lot::where('id', $lot->id)->update(array('status' => 1));
                        Vehicle::where('id', $vehicle->id)->update(array('status' => 1));
                        Parking::create(array('vehicleId' => $vehicle->id, 'lotId' => $lot->id));

                        $parkedVehicle = Vehicle::findOrFail($vehicleId);

                        return response()->json(['status' => 'Vehicle Parked Successfully', 'vehicle_details'=> $parkedVehicle], $this->successStatus);
                    } else {
                        return response()->json(['status' => 'Parking lot ' . $lotId . ' already occupied, choose different lot', 'Free lots' => $lotArr], $this->successStatus);
                    }
                } else {
                    return response()->json(['No free parking space available for '.$vehicle->category], $this->successStatus);
                }
            } else {
                $parking = Parking::where('vehicleId', $vehicle->id)->first();
                return response()->json(['status' => 'Vehicle Already Parked', 'vehicle _details' => $vehicle, 'parking_lot_number' => $parking->lotId], $this->successStatus);
            }
        } else {
            return response()->json(['status' => 'No Vehicle found with Vehicle ID: '.$vehicleId], $this->successStatus);
        }
    }

    public function departVehicle($vehicleId)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);

        if($vehicle !== null)
        {
            if($vehicle->status === 1)
            {
                $parking = Parking::where('vehicleId', $vehicle->id)->orderBy('id', 'desc')->first();

                if($parking !== null)
                {
                    Lot::where('id', $parking->lotId)->update(array('status' => 0));
                    Vehicle::where('id', $parking->vehicleId)->update(array('status' => 0));
                    $departVehicle = Vehicle::findOrFail($vehicleId);

                    $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', \Carbon\Carbon::now());
                    $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $parking->updated_at);


                    $diff_in_minutes = $to->diffInMinutes($from);

                    return response()->json(['status' => 'Vehicle Departed Successfully', 'vehicle_details'=> $departVehicle, 'Parking Cost' => $this->PARKING_RATE * $diff_in_minutes. ' Euros'], $this->successStatus);
                } else {
                    return response()->json(['status' => 'Vehicle not Parked', 'vehicle _details' => $vehicle], $this->successStatus);
                }
            } else {
                return response()->json(['status' => 'Vehicle not Parked', 'vehicle _details' => $vehicle], $this->successStatus);
            }
        } else {
            return response()->json(['status' => 'No Vehicle found with Vehicle ID: '.$vehicleId], $this->successStatus);
        }
    }

    public function getParkingLotInstance()
    {
        $totalCarLots = Lot::where('category', 'car')->count();
        $totalBusLots = Lot::where('category', 'bus')->count();
        $totalMotorbikeLots = Lot::where('category', 'motorbike')->count();

        $carSpaces = Lot::where('category', 'car')->where('status', 0)->count();
        $busSpaces = Lot::where('category', 'bus')->where('status', 0)->count();
        $motorbikeSpaces = Lot::where('category', 'motorbike')->where('status', 0)->count();

        $parkingLot = Lot::all();

        $parkingLotInstance = [];

        foreach ($parkingLot as $lot)
        {
            $slot = [];
            if($lot->status === 1)
            {
                $vehicle = Vehicle::where('id', (Parking::where('lotId', $lot->id)->orderBy('id', 'desc')->first()->vehicleId))->where('status', 1)->get(['id', 'status', 'model', 'manufacturer', 'category']);

                $slot['id'] = $lot->id;
                $slot['status'] = 'occupied';
                $slot['category'] = $lot->category;
                $slot['vehicle'] = $vehicle;
            } else {
                $slot['id'] = $lot->id;
                $slot['status'] = 'free';
                $slot['category'] = $lot->category;
            }
            array_push( $parkingLotInstance, $slot);
        }

        return response()->json(
            [
                'Total Car Lots' => $totalCarLots,
                'Total Bus Lots' => $totalBusLots,
                'Total Motorbike Lots' => $totalMotorbikeLots,
                'Free Spaces' => ['Car' => $carSpaces, 'Bus' => $busSpaces, 'Motorbike' => $motorbikeSpaces],
                'Parking Lot Status' => $parkingLotInstance
            ], $this->successStatus);

    }

    public function getParkingLotInstanceById($id)
    {

        $parkingLot = Lot::where('id', $id)->get();

        $parkingLotInstance = [];

        foreach ($parkingLot as $lot)
        {
            $slot = [];
            if($lot->status === 1)
            {
                $vehicle = Vehicle::where('id', (Parking::where('lotId', $lot->id)->orderBy('id', 'desc')->first()->vehicleId))->where('status', 1)->get(['id', 'status', 'model', 'manufacturer', 'category']);

                $slot['id'] = $lot->id;
                $slot['status'] = 'occupied';
                $slot['category'] = $lot->category;
                $slot['vehicle'] = $vehicle;
            } else {
                $slot['id'] = $lot->id;
                $slot['status'] = 'free';
                $slot['category'] = $lot->category;
            }
            array_push( $parkingLotInstance, $slot);
        }

        return response()->json(
            [
                'Parking Lot Status' => $parkingLotInstance
            ], $this->successStatus);

    }
}
