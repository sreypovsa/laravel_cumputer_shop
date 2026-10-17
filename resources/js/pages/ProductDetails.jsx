import React, { useState } from 'react';
import { 
  Star, ShoppingBag, Zap, Heart, ShieldCheck, Truck, RotateCcw, 
  Check, Gift, ChevronRight, Share2, Info 
} from 'lucide-react';
import { ProductGallery } from '../components/ProductGallery';
import { useShop } from '../context/ShopContext';
import { productsData } from '../data/mockData';

export const ProductDetails = () => {
  const { 
    selectedProduct, 
    addToCart, 
    toggleWishlist, 
    isInWishlist, 
    navigateTo, 
    lang, 
    t 
  } = useShop();

  const [quantity, setQuantity] = useState(1);
  const [activeTab, setActiveTab] = useState('specs'); // 'specs', 'desc', 'reviews', 'warranty'

  const product = selectedProduct || productsData[0];
  const isWish = isInWishlist(product.id);

  const discountPercent = product.originalPrice && product.originalPrice > product.price
    ? Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100)
    : 0;

  const handleAddToCart = () => {
    addToCart(product, quantity);
  };

  const handleBuyNow = () => {
    addToCart(product, quantity, false);
    navigateTo('checkout');
  };

  return (
    <div className="py-8 bg-[#F8FAFC]">
      <div className="max-w-7xl mx-auto px-4">
        {/* Breadcrumb */}
        <div className="flex items-center gap-1.5 text-xs text-slate-400 mb-6 flex-wrap">
          <button onClick={() => navigateTo('home')} className="hover:text-blue-600 cursor-pointer">
            Home
          </button>
          <ChevronRight className="w-3.5 h-3.5" />
          <button onClick={() => navigateTo('shop')} className="hover:text-blue-600 cursor-pointer">
            {t.shop.title}
          </button>
          <ChevronRight className="w-3.5 h-3.5" />
          <span className="text-slate-800 font-semibold truncate max-w-xs sm:max-w-md">
            {product.name}
          </span>
        </div>

        {/* Top Product Hero: Gallery + Buying Details */}
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
          
          {/* Left: Gallery (5 cols) */}
          <div className="lg:col-span-6">
            <ProductGallery images={product.gallery} productName={product.name} />
            
            {/* Free Gift Card below gallery */}
            {product.freeGifts && (
              <div className="mt-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 flex items-start gap-3">
                <div className="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                  <Gift className="w-4 h-4" />
                </div>
                <div>
                  <h4 className="text-xs font-bold text-emerald-900 uppercase tracking-wider">
                    {lang === 'km' ? 'កាដូថែមជូនពិសេស' : 'Complimentary Gift Package'}
                  </h4>
                  <p className="text-xs text-emerald-700 mt-0.5 leading-relaxed font-medium">
                    {product.freeGifts}
                  </p>
                </div>
              </div>
            )}
          </div>

          {/* Right: Info & Actions (7 cols) */}
          <div className="lg:col-span-6 flex flex-col justify-between space-y-6">
            <div className="space-y-4">
              {/* Brand, Stock, SKU */}
              <div className="flex flex-wrap items-center justify-between gap-2 text-xs">
                <div className="flex items-center gap-2">
                  <span className="px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 font-bold uppercase tracking-wider">
                    {product.brand}
                  </span>
                  <span className="text-slate-400 font-mono">SKU: {product.sku}</span>
                </div>
                <span className="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md">
                  <Check className="w-3.5 h-3.5" />
                  <span>{t.productCard.inStock} ({product.stock} units available)</span>
                </span>
              </div>

              {/* Title */}
              <h1 className="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                {lang === 'km' && product.name_km ? product.name_km : product.name}
              </h1>

              {/* Rating */}
              <div className="flex items-center gap-3 text-xs text-slate-500">
                <div className="flex items-center gap-1 text-amber-500 font-bold">
                  <Star className="w-4 h-4 fill-current" />
                  <span>{product.rating}</span>
                </div>
                <span>•</span>
                <span className="text-blue-600 font-medium">{product.reviewsCount} customer reviews</span>
                <span>•</span>
                <span className="text-slate-500 font-medium">Cambodia Stock</span>
              </div>

              {/* Price Box */}
              <div className="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 flex items-baseline gap-3">
                <span className="text-3xl sm:text-4xl font-black text-blue-600">
                  ${product.price.toFixed(2)}
                </span>
                {product.originalPrice && product.originalPrice > product.price && (
                  <>
                    <span className="text-lg text-slate-400 line-through font-medium">
                      ${product.originalPrice.toFixed(2)}
                    </span>
                    <span className="px-2.5 py-1 text-xs font-extrabold text-red-600 bg-red-100 rounded-lg">
                      Save ${(product.originalPrice - product.price).toFixed(2)} ({discountPercent}% OFF)
                    </span>
                  </>
                )}
              </div>

              {/* Short Specs Quick List */}
              <div className="grid grid-cols-2 gap-2 text-xs">
                <div className="p-3 bg-slate-50 rounded-xl border border-slate-100">
                  <span className="text-[10px] text-slate-400 uppercase font-bold block">Processor (CPU)</span>
                  <span className="font-semibold text-slate-900 truncate block mt-0.5">{product.specs.cpu}</span>
                </div>
                <div className="p-3 bg-slate-50 rounded-xl border border-slate-100">
                  <span className="text-[10px] text-slate-400 uppercase font-bold block">Graphics (GPU)</span>
                  <span className="font-semibold text-blue-700 truncate block mt-0.5">{product.specs.gpu}</span>
                </div>
                <div className="p-3 bg-slate-50 rounded-xl border border-slate-100">
                  <span className="text-[10px] text-slate-400 uppercase font-bold block">Memory & Storage</span>
                  <span className="font-semibold text-slate-900 truncate block mt-0.5">{product.specs.ram}</span>
                </div>
                <div className="p-3 bg-slate-50 rounded-xl border border-slate-100">
                  <span className="text-[10px] text-slate-400 uppercase font-bold block">Screen / Display</span>
                  <span className="font-semibold text-slate-900 truncate block mt-0.5">{product.specs.display}</span>
                </div>
              </div>

              {/* Quantity Selector & CTAs */}
              <div className="pt-2 space-y-3">
                <div className="flex items-center gap-3">
                  <div className="flex items-center border border-slate-300 rounded-xl overflow-hidden bg-white shadow-xs">
                    <button
                      onClick={() => setQuantity(Math.max(1, quantity - 1))}
                      className="w-10 h-11 flex items-center justify-center hover:bg-slate-100 text-slate-700 font-bold cursor-pointer"
                    >
                      -
                    </button>
                    <span className="w-12 text-center text-sm font-bold text-slate-900">
                      {quantity}
                    </span>
                    <button
                      onClick={() => setQuantity(quantity + 1)}
                      className="w-10 h-11 flex items-center justify-center hover:bg-slate-100 text-slate-700 font-bold cursor-pointer"
                    >
                      +
                    </button>
                  </div>

                  <button
                    onClick={handleAddToCart}
                    className="flex-1 h-11 bg-blue-600 hover:bg-blue-700 active:scale-98 text-white rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2 shadow-md shadow-blue-600/20 cursor-pointer"
                  >
                    <ShoppingBag className="w-4 h-4" />
                    <span>{t.productCard.addToCart}</span>
                  </button>

                  <button
                    onClick={() => toggleWishlist(product)}
                    className={`w-11 h-11 rounded-xl border flex items-center justify-center transition-colors cursor-pointer shadow-xs ${
                      isWish
                        ? 'border-red-200 bg-red-50 text-red-500'
                        : 'border-slate-300 hover:border-slate-400 text-slate-600 hover:bg-slate-50'
                    }`}
                  >
                    <Heart className={`w-5 h-5 ${isWish ? 'fill-current' : ''}`} />
                  </button>
                </div>

                <button
                  onClick={handleBuyNow}
                  className="w-full h-11 bg-slate-900 hover:bg-slate-950 active:scale-98 text-white rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2 shadow-md cursor-pointer"
                >
                  <Zap className="w-4 h-4 text-amber-400" />
                  <span>Buy Now with ABA Pay / KHQR</span>
                </button>
              </div>

              {/* Service Badges */}
              <div className="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100 text-xs text-slate-600">
                <div className="flex items-center gap-2">
                  <ShieldCheck className="w-4 h-4 text-blue-600" />
                  <span>{product.specs.warranty}</span>
                </div>
                <div className="flex items-center gap-2">
                  <Truck className="w-4 h-4 text-blue-600" />
                  <span>Free Phnom Penh delivery</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Detailed Tabs: Specifications, Description, Reviews, Warranty */}
        <div className="mt-10 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs">
          <div className="flex items-center gap-2 sm:gap-6 border-b border-slate-200 overflow-x-auto pb-px">
            <button
              onClick={() => setActiveTab('specs')}
              className={`pb-4 text-sm font-bold transition-colors border-b-2 cursor-pointer whitespace-nowrap ${
                activeTab === 'specs'
                  ? 'border-blue-600 text-blue-600'
                  : 'border-transparent text-slate-500 hover:text-slate-800'
              }`}
            >
              Specifications
            </button>
            <button
              onClick={() => setActiveTab('desc')}
              className={`pb-4 text-sm font-bold transition-colors border-b-2 cursor-pointer whitespace-nowrap ${
                activeTab === 'desc'
                  ? 'border-blue-600 text-blue-600'
                  : 'border-transparent text-slate-500 hover:text-slate-800'
              }`}
            >
              Description & Features
            </button>
            <button
              onClick={() => setActiveTab('warranty')}
              className={`pb-4 text-sm font-bold transition-colors border-b-2 cursor-pointer whitespace-nowrap ${
                activeTab === 'warranty'
                  ? 'border-blue-600 text-blue-600'
                  : 'border-transparent text-slate-500 hover:text-slate-800'
              }`}
            >
              Warranty & Service
            </button>
            <button
              onClick={() => setActiveTab('reviews')}
              className={`pb-4 text-sm font-bold transition-colors border-b-2 cursor-pointer whitespace-nowrap ${
                activeTab === 'reviews'
                  ? 'border-blue-600 text-blue-600'
                  : 'border-transparent text-slate-500 hover:text-slate-800'
              }`}
            >
              Reviews ({product.reviewsCount})
            </button>
          </div>

          <div className="pt-6">
            {activeTab === 'specs' && (
              <div className="space-y-4">
                <h3 className="text-base font-bold text-slate-900">Technical Specifications</h3>
                <div className="divide-y divide-slate-100 border border-slate-200 rounded-xl overflow-hidden text-xs">
                  {Object.entries(product.specs).map(([key, val]) => (
                    <div key={key} className="grid grid-cols-1 sm:grid-cols-3 p-3.5 hover:bg-slate-50">
                      <span className="font-bold text-slate-700 uppercase tracking-wider text-[11px]">
                        {key.toUpperCase()}
                      </span>
                      <span className="sm:col-span-2 text-slate-800 font-medium">
                        {val}
                      </span>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {activeTab === 'desc' && (
              <div className="space-y-4 text-sm text-slate-700 leading-relaxed max-w-3xl">
                <p>
                  {lang === 'km' && product.description_km ? product.description_km : product.description_en}
                </p>
                <div className="p-4 rounded-xl bg-blue-50/60 border border-blue-200/60 text-xs text-blue-950 space-y-1">
                  <div className="font-bold">Authenticity Guarantee</div>
                  <div>
                    This machine is imported through authorized distribution channels in Cambodia. It comes in original sealed retail packaging with manufacturer documentation and valid serial verification.
                  </div>
                </div>
              </div>
            )}

            {activeTab === 'warranty' && (
              <div className="space-y-4 text-xs sm:text-sm text-slate-700 max-w-3xl leading-relaxed">
                <h4 className="font-bold text-slate-900">Official Cambodian Service Center Policy</h4>
                <p>
                  All purchases at QuickTech Cambodia are backed by authorized manufacturer warranty. Service locations are available in Phnom Penh, Siem Reap, and Battambang.
                </p>
                <ul className="list-disc pl-5 space-y-1.5 text-xs text-slate-600">
                  <li>Hardware defects covered under replacement or authorized repair.</li>
                  <li>Free lifetime BIOS update and thermal paste re-application service at QuickTech workshop.</li>
                  <li>Proof of purchase: Keep your QuickTech digital receipt / invoice sent via Telegram/SMS.</li>
                </ul>
              </div>
            )}

            {activeTab === 'reviews' && (
              <div className="space-y-4">
                <div className="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200 max-w-md">
                  <div className="text-3xl font-black text-slate-900">{product.rating}</div>
                  <div>
                    <div className="flex text-amber-500">
                      {[...Array(5)].map((_, i) => (
                        <Star key={i} className="w-4 h-4 fill-current" />
                      ))}
                    </div>
                    <div className="text-xs text-slate-500 mt-0.5">Based on {product.reviewsCount} verified buyers</div>
                  </div>
                </div>

                <div className="space-y-3 pt-2 max-w-2xl">
                  <div className="p-4 rounded-xl border border-slate-200 space-y-1 text-xs">
                    <div className="flex items-center justify-between">
                      <span className="font-bold text-slate-900">Rathana S. (Verified Buyer - Phnom Penh)</span>
                      <span className="text-slate-400">2 days ago</span>
                    </div>
                    <div className="flex text-amber-500">
                      {[...Array(5)].map((_, i) => (
                        <Star key={i} className="w-3.5 h-3.5 fill-current" />
                      ))}
                    </div>
                    <p className="text-slate-600 pt-1">
                      Received in less than 2 hours in Sen Sok! Sealed box, tested Cinebench and temperatures are under 75C. Free backpack and mouse are high quality.
                    </p>
                  </div>
                </div>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};
