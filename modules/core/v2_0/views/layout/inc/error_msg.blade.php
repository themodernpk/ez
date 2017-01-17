        @if($errors->any())
            <div class="alert alert-danger">
                <button aria-hidden=true data-dismiss=alert class=close type=button>X</button>
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif