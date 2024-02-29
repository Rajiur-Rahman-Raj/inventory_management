<div class="sidebar-bottom">
    <!-- Default dropup button -->
    <div class="btn-group dropup">
        <button
            type="button"
            class="dropdown-toggle"
            data-bs-toggle="dropdown"
            aria-expanded="false">
            <img src="{{getFile(config('location.companyLogo.path').@Auth::user()->activeCompany->logo)}}"
                 alt="..."/> {{@Auth::user()->activeCompany->name}}
            @if(@Auth::user()->activeCompany == null)
               <sapn class="text-muted ml-0">
                   No Active
               </sapn>
            @endif
        </button>
        @if($companies)
            <ul
                class="dropdown-menu"
                aria-labelledby="dropdownMenuButton1">
                @forelse($companies as $item)
                    <li>
                        <a class="dropdown-item" href="{{route('user.companyActive',$item->id)}}">
                            <img src="{{getFile(config('location.companyLogo.path').$item->logo)}}"
                                 alt="{{ $item->name }}"/>
                            {{ $item->name }}
                        </a>
                    </li>
                @empty
                @endforelse
                <hr/>
                <li>
                    <a class="dropdown-item" href="{{route('user.companyList')}}">
                        <i class="fal fa-cog"></i>@lang('All Companies')</a>
                </li>
            </ul>
        @endif
    </div>
</div>
