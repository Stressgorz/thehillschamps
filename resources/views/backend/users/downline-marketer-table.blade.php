<!-- Create a partial for recursion -->
@if (!empty($downline))
    @foreach ($downline as $item)
        <li>
            @if (!empty($item['downline']))
                <a href="javascript:void(0);">
                    <div class="member-view-box">
                        <div class="member-image">
                            <div class="member-details">
                                <a href="{{route('users.show',$item['id'])}}" ><h5> {{ $item['user'] }}</h5></a>
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="active">
                    @include('backend.users.downline-marketer-table', ['downline' => $item['downline']])
                </ul>
            @else
                <div href="javascript:void(0);">
                    <div class="member-view-box">
                        <div class="member-image">
                            <div class="member-details">
                                <a href="{{route('users.show',$item['id'])}}" ><h5> {{ $item['user'] }}</h5></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </li>
    @endforeach
@endif
