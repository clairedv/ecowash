<div class="alert text-center w-full alert text-white">
    {{$alert->short_text}}
    <a class="text-sm" @click.prevent @click=$modal.open() href="#">
         more info...
    </a>
</div>

<modal class="alert__modal"
    @if (Cookie::get('ecowash_alert') != $alert->id )
        open-on-load="true"
    @endif
    disable-scroll="true">
    <template v-slot:header>
        <h1>{{$alert->short_text}}</h1>
    </template>

    {!!$alert->long_text!!}

    <template v-slot:footer>
        <div class="button-group">
            <button @click="$modal.close(); setCookie('ecowash_alert', {{ $alert->id }}, '10s')" class="btn btn-teal">Okay</button>
        </div>
    </template>

</modal>
