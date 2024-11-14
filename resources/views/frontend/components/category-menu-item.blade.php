@foreach($categories as $category)
    <div class="card">
        <div class="card-header" id="heading{{ $category->id }}">
            <h2 class="mb-0">
                <button class="btn btn-link text-black {{ $currentCategory && ($currentCategory->id == $category->id || $currentCategory->ancestors->contains($category)) ? '' : 'collapsed' }}"
                        type="button"
                        data-toggle="collapse"
                        data-target="#collapse{{ $category->id }}"
                        aria-expanded="{{ $currentCategory && ($currentCategory->id == $category->id || $currentCategory->ancestors->contains($category)) ? 'true' : 'false' }}"
                        aria-controls="collapse{{ $category->id }}">
                    {{ $category->name }}
                </button>
            </h2>
        </div>

        @if($category->children->count() > 0)
            <div id="collapse{{ $category->id }}"
                 class="collapse {{ $currentCategory && ($currentCategory->id == $category->id || $currentCategory->isDescendantOf($category)) ? 'show' : '' }}"
                 aria-labelledby="heading{{ $category->id }}"
                 data-parent="#accordionLeftMenu">
                <div class="card-body">
                    <ul class="accordin-menu">
                        @foreach($category->children as $child)
                            <li>
                                <a href="{{ route('products.category', $child->id) }}"
                                   class="{{ $currentCategory && $currentCategory->id == $child->id ? 'active' : '' }}">
                                    {{ $child->name }}
                                </a>
                                @if($child->children->count() > 0)
                                    <ul class="sub-menu">
                                        @foreach($child->children as $grandChild)
                                            <li>
                                                <a href="{{ route('products.category', $grandChild->id) }}"
                                                   class="{{ $currentCategory && $currentCategory->id == $grandChild->id ? 'active' : '' }}">
                                                    {{ $grandChild->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
@endforeach 