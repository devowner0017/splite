<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\GetContactsRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Utilities\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller {

    public function index(GetContactsRequest $request): JsonResponse {
        // $paginatedItems = $request->getPlanner()->contacts()->paginate();
        // return $this->success($paginatedItems->items(), [
        //     'meta' => [
        //         'page' => $paginatedItems->currentPage(),
        //         'rpp' => $paginatedItems->perPage(),
        //         'total' => $paginatedItems->total(),
        //     ],
        // ]);
        $paginatedItems = $request->getPlanner()->contacts()->get();
        return $this->success($paginatedItems->toArray());
    }

    public function store(CreateContactRequest $request): JsonResponse {

        /** @var Contact $exists */
        echo $request->email."ok";
        $exists = Contact::query()
            ->where('planner_id', $request->getPlanner()->id)
            ->where('email', $request->email)
            ->first();

        if ($exists) {
            return $this->error(Message::CONTACT_EXISTS, 422);
        }

        $contact = new Contact();

        $contact->planner_id = $request->getPlanner()->id;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->email = $request->email;

        $contact->saveOrFail();

        return $this->success($contact->refresh()->toArray(), [], 201);
    }

    public function update(Contact $contact, UpdateContactRequest $request): JsonResponse {

        if ($contact->planner_id !== $request->getPlanner()->id) {
            return $this->error(Message::NOT_FOUND, 404);
        }

        $contact->fill($request->validated());
        $contact->saveOrFail();

        return $this->success($contact->toArray());
    }
}
