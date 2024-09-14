<?php

namespace App\Services\Contact;

use App\Base\ServiceResult;
use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactServices
{
    public function getAllContact(): ServiceResult
    {
        try {
            $contacts = Contact::all();
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: $contacts, status: 200);
    }

    public function createContact($request): ServiceResult
    {
        try {
            $result = Contact::create($request);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: $result, status: 201);
    }


    public function showContact(string $id): ServiceResult
    {
        try {
            $contact = Contact::findOrFail($id);
        } catch (ModelNotFoundException $err) {
            return new ServiceResult(ok: false, data: "Contact Not A Found :)", status: 404);

        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: $contact, status: 200);
    }

    public function deleteContact(string $id): ServiceResult
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
        } catch (ModelNotFoundException $err) {
            return new ServiceResult(ok: false, data: "Contact Not A Found :(", status: 404);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: [], status: 204);
    }
}
