 <div class="card product-card">
     <div class="product-image position-relative">
         <img src="{{ $product->image_path }}" alt="" class="card-img-top"
             style="width: 100%; height: 250px; object-fit: cover;">
         <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

         <div class="product-action">
             <a class="btn btn-dark" href="#">
                 <i class="fa fa-shopping-cart"></i> Add To Cart
             </a>
         </div>
     </div>
     <div class="card-body text-center mt-3">
         <a class="h6 link" href="{{ route('site.product',$product->slug) }}">{{ $product->title }}</a>
         <div class="price mt-2">
             <span class="h5"><strong>${{ $product->price }}</strong></span>
             @if ($product->compare_price)
                 <span class="h6 text-underline"><del>${{ $product->compare_price }}</del></span>
             @endif
         </div>
     </div>
 </div>

