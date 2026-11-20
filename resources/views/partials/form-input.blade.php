{{--
    A labelled input with its error message and optional hint.

    @include('partials.form-input', [
        'name' => 'email',             required
        'label' => 'Email',            required
        'type' => 'email',             default: text
        'hint' => '...',               optional, shown under the field
        'revealable' => true,          optional, adds a show/hide button (password fields)
        'autocomplete' => 'email',     optional
        'inputmode' => 'email',        optional
        'minlength' => 8,              optional
        'maxlength' => 255,            optional
        'plainText' => true,           optional, turns off capitalization and spellcheck (emails)
    ])
--}}
<div class="cq-field">
    <label class="form-label" for="field-{{ $name }}">{{ $label }}</label>
    <div @class(['cq-input-wrap', 'has-reveal' => $revealable ?? false])>
        <input id="field-{{ $name }}" name="{{ $name }}" type="{{ $type ?? 'text' }}" required
               @class(['form-control', 'is-invalid' => $errors->has($name)])
               @if (($type ?? 'text') !== 'password') value="{{ old($name) }}" @endif
               @isset($autocomplete) autocomplete="{{ $autocomplete }}" @endisset
               @isset($inputmode) inputmode="{{ $inputmode }}" @endisset
               @isset($minlength) minlength="{{ $minlength }}" @endisset
               @isset($maxlength) maxlength="{{ $maxlength }}" @endisset
               @if ($plainText ?? false) autocapitalize="none" spellcheck="false" @endif
               @if (isset($hint) || $errors->has($name))
                   aria-describedby="{{ trim((isset($hint) ? "field-{$name}-hint " : '').($errors->has($name) ? "field-{$name}-error" : '')) }}"
               @endif
               @error($name) aria-invalid="true" @enderror>
        @if ($revealable ?? false)
            {{-- Hidden until JS is ready, so it never shows as a dead button. --}}
            <button type="button" class="cq-reveal" data-reveal="field-{{ $name }}" aria-controls="field-{{ $name }}" aria-pressed="false"
                    aria-label="Tampilkan kata sandi" data-label-show="Tampilkan kata sandi" data-label-hide="Sembunyikan kata sandi" hidden>
                <i class="bi bi-eye" aria-hidden="true"></i>
            </button>
        @endif
    </div>
    @isset($hint)
        <div class="form-text" id="field-{{ $name }}-hint">{{ $hint }}</div>
    @endisset
    @error($name)
        <div class="invalid-feedback d-block" id="field-{{ $name }}-error">{{ $message }}</div>
    @enderror
</div>
