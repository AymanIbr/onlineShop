 <div class="card product-card">
     <div class="product-image position-relative">
         <img src="{{ $product->image_path }}" alt="" class="card-img-top"
             style="width: 100%; height: 250px; object-fit: cover;">


         <a class="whishlist add-to-wishlist {{ in_array($product->id, $wishlistItems ?? []) ? 'active' : '' }}"
             data-id="{{ $product->id }}" href="javascript:void(0)" title="Add to Wishlist">
             <i class="{{ in_array($product->id, $wishlistItems ?? []) ? 'fas' : 'far' }} fa-heart"></i>
         </a>

         @if ($product->track_qty == 1)
             @if ($product->quantity > 0)
                 <div class="product-action">
                     <button type="button" class="btn btn-dark add-to-cart" data-id="{{ $product->id }}">
                         <i class="fa fa-shopping-cart"></i> Add To Cart
                     </button>
                 </div>
             @else
                 <div class="product-action">
                     <button type="button" class="btn btn-dark ">
                         Out Of Stock
                     </button>
                 </div>
             @endif
         @else
             <div class="product-action">
                 <button type="button" class="btn btn-dark add-to-cart" data-id="{{ $product->id }}">
                     <i class="fa fa-shopping-cart"></i> Add To Cart
                 </button>
             </div>
         @endif

     </div>
     <div class="card-body text-center mt-3">
         <a class="h6 link" href="{{ route('site.product', $product->slug) }}">{{ $product->title }}</a>
         <div class="price mt-2">
             <span class="h5"><strong>${{ $product->price }}</strong></span>
             @if ($product->compare_price)
                 <span class="h6 text-underline"><del>${{ $product->compare_price }}</del></span>
             @endif
         </div>
     </div>
 </div>
