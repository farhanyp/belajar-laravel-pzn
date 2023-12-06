<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactCreateRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function create (ContactCreateRequest $request) : JsonResponse {

        $request->validated();
        $data = $request->all();

        $user = User::query()->find(Auth::user()->id);

        $contact = new Contact($data);
        $contact->user_id = $user->id;
        $contact->save();

        return (new ContactResource($contact))->response()->setStatusCode(201);
    }

    public function get (int $id) : ContactResource {

        $user = User::query()->find(Auth::user()->id);
        $contact = Contact::query()->where("id", $id)->where("user_id", $user->id)->first();

        if(!$contact){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        return new ContactResource($contact);
    }

    public function update (int $id, ContactUpdateRequest $request): ContactResource{

        $request->validated();
        $data = $request->all();

        $user = User::query()->find(Auth::user()->id);
        $contact = Contact::query()->where("id", $id)->where("user_id", $user->id)->first();
        if(!$contact){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $contact->fill($data);
        $contact->save();

        return new ContactResource($contact);
    }

    public function remove(int $id) : JsonResponse {
        $user = User::query()->find(Auth::user()->id);
        $contact = Contact::query()->where("id", $id)->where("user_id", $user->id)->first();
        if(!$contact){
            throw new HttpResponseException(response()->json([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }
    
        $contact->delete();
        return response()->json([
            "data" => true
        ])->setStatusCode(200);
    }

    public function search(Request $request): ContactCollection{

        $page = $request->input("page", 1);
        $size = $request->input("size", 10);

        $user = User::query()->find(Auth::user()->id);
        $contacts = Contact::query()->where("user_id", $user->id);

        $contacts = $contacts->where(function(Builder $builder) use($request){
            $name = $request->input("name");
            if($name){
                $builder->where(function (Builder $builder) use($name){
                    $builder->orWhere("first_name", 'like', '%'. $name . '%');
                    $builder->orWhere("last_name", 'like', '%'. $name . '%');
                });
            }

            $email = $request->input('email');
            if($email){
                $builder->where('email', 'like', '%'. $email . '%');
            }

            $phone = $request->input('phone');
            if($phone){
                $builder->where('phone', 'like', '%'. $phone . '%');
            }
        });

        $contacts = $contacts->paginate(perPage: $size, page: $page);

        return new ContactCollection($contacts);
    }
}
