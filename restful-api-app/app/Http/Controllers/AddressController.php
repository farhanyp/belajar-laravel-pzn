<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressCreateRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function create(int $idContact, AddressCreateRequest $request){

        $request->validated();
        $data = $request->all();

        $user = User::query()->find(Auth::user()->id);
        $contact = Contact::query()->where("id", $idContact)->where("user_id", $user->id)->first();
        if(!$contact){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $address = new Address($data);
        $address->contact_id = $contact->id;
        $address->save();

        return (new AddressResource($address))->response()->setStatusCode(201);
    }

    public function get(int $idContact, int $idAddress): AddressResource{

        $user = User::query()->find(Auth::user()->id);
        $contact = Contact::query()->where("id", $idContact)->where("user_id", $user->id)->first();
        if(!$contact){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $address = Address::query()->where("contact_id", $contact->id)->where("id", $idAddress)->first();
        if(!$address){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        return new AddressResource($address);
    }

    public function update(int $idContact, int $idAddress, AddressUpdateRequest $request): AddressResource{

        $request->validated();
        $data = $request->all();

        $user = User::query()->find(Auth::user()->id);
        $contact = Contact::query()->where("id", $idContact)->where("user_id", $user->id)->first();
        if(!$contact){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $address = Address::query()->where("contact_id", $contact->id)->where("id", $idAddress)->first();
        if(!$address){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $address->fill($data);
        $address->save();

        return new AddressResource($address);
    }

    public function remove(int $idContact, int $idAddress): JsonResponse{

        $user = User::query()->find(Auth::user()->id);
        $contact = Contact::query()->where("id", $idContact)->where("user_id", $user->id)->first();
        if(!$contact){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $address = Address::query()->where("contact_id", $contact->id)->where("id", $idAddress)->first();
        if(!$address){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $address->delete();
        $address->save();

        return response()->json([
            "data" => true
        ]);
    }

    public function list(int $idContact): JsonResponse{

        $user = User::query()->find(Auth::user()->id);
        $contact = Contact::query()->where("id", $idContact)->where("user_id", $user->id)->first();
        if(!$contact){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $address = Address::query()->where("contact_id", $contact->id)->get();

        return (AddressResource::collection($address))->response()->setStatusCode(200);
    }
}
