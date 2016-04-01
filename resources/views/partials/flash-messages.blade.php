@if(Session::has('message'))
        <div class="alert alert-{{ Session::get('message-type', 'info') }} text-center flash">
          <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          {{ Session::get('message') }}
        </div>
@endif