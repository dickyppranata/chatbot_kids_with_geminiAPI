<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message'    => ['required', 'string', 'max:2000'],
            'session_id' => ['sometimes', 'nullable', 'integer', 'exists:chat_sessions,id'],
            'topic_id'   => ['sometimes', 'nullable', 'integer', 'exists:topics,id'],
        ];
    }

    /**
     * Custom error messages dalam Bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'message.required'   => 'Pesan tidak boleh kosong.',
            'message.max'        => 'Pesan maksimal 2000 karakter.',
            'session_id.exists'  => 'Sesi chat tidak ditemukan.',
        ];
    }
}
