import React from 'react';
import { ArrowRight, Sparkles, Cpu, Zap, ShieldCheck, CheckCircle2 } from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { productsData } from '../data/mockData';

export const Hero = () => {
  const { t, navigateTo, lang } = useShop();

  const handleHeroLaptop = () => {
    navigateTo('category', { category: 'gaming-laptops' });
  };

  const handleHeroComponents = () => {
    navigateTo('category', { category: 'pc-components' });
  };

  const showcaseProduct = productsData[0]; // ASUS ROG Strix G16

  return (
    <section className="relative bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-white overflow-hidden border-b border-slate-800">
      {/* Subtle background glow */}
      <div className="absolute top-0 right-1/4 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none" />
      <div className="absolute bottom-0 left-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none" />

      <div className="max-w-7xl mx-auto px-4 py-12 md:py-16 lg:py-20">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
          
          {/* Left Column: Heading & CTAs */}
          <div className="lg:col-span-7 space-y-6 text-center lg:text-left">
            {/* Small Badge */}
            <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-bold uppercase tracking-wider">
              <Sparkles className="w-3.5 h-3.5 text-blue-400" />
              <span>{t.hero.badge}</span>
            </div>

            {/* Large Heading */}
            <h1 className="text-3xl sm:text-4xl md:text-5xl lg:text-5xl font-black tracking-tight text-white leading-tight">
              {t.hero.headingStart}{' '}
              <span className="text-blue-500 relative inline-block">
                {t.hero.headingHighlight}
              </span>{' '}
              {t.hero.headingEnd}
            </h1>

            {/* Business Description */}
            <p className="text-slate-300 text-sm sm:text-base md:text-lg leading-relaxed max-w-2xl mx-auto lg:mx-0 font-normal">
              {t.hero.description}
            </p>

            {/* Action Buttons */}
            <div className="flex flex-wrap items-center justify-center lg:justify-start gap-3 pt-2">
              <button
                onClick={handleHeroLaptop}
                className="px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 transition-all flex items-center gap-2 cursor-pointer"
              >
                <span>{t.hero.shopLaptops}</span>
                <ArrowRight className="w-4 h-4" />
              </button>

              <button
                onClick={handleHeroComponents}
                className="px-6 py-3.5 bg-slate-800/80 hover:bg-slate-700 text-slate-200 hover:text-white text-sm font-semibold rounded-xl border border-slate-700 transition-colors flex items-center gap-2 cursor-pointer"
              >
                <Cpu className="w-4 h-4 text-blue-400" />
                <span>{t.hero.pcParts}</span>
              </button>
            </div>

            {/* Quick Micro-points */}
            <div className="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-4 sm:gap-6 text-xs text-slate-400">
              <div className="flex items-center gap-1.5">
                <CheckCircle2 className="w-4 h-4 text-emerald-400" />
                <span>{lang === 'km' ? 'ធានាផលិតផលសុទ្ធ 100%' : '100% Genuine Cambodian Stock'}</span>
              </div>
              <div className="flex items-center gap-1.5">
                <CheckCircle2 className="w-4 h-4 text-emerald-400" />
                <span>{lang === 'km' ? 'មានកាដូថែមឥតគិតថ្លៃ' : 'Free Gift Bundles Included'}</span>
              </div>
              <div className="flex items-center gap-1.5">
                <CheckCircle2 className="w-4 h-4 text-emerald-400" />
                <span>{lang === 'km' ? 'ទូទាត់តាម ABA KHQR' : 'Instant ABA KHQR Checkout'}</span>
              </div>
            </div>
          </div>

          {/* Right Column: Hero Showcase Card */}
          <div className="lg:col-span-5 relative">
            <div className="relative mx-auto max-w-md lg:max-w-none">
              {/* Product Showcase Container */}
              <div className="relative rounded-2xl bg-gradient-to-b from-slate-800/80 to-slate-900/90 border border-slate-700/80 p-5 shadow-2xl backdrop-blur-xs group">
                
                {/* Floating Top Tag */}
                <div className="flex items-center justify-between mb-3">
                  <span className="px-3 py-1 bg-red-500/20 border border-red-500/40 text-red-400 rounded-full text-xs font-bold flex items-center gap-1">
                    <Zap className="w-3.5 h-3.5" />
                    <span>Special Deal: Save ${showcaseProduct.originalPrice - showcaseProduct.price}</span>
                  </span>
                  <span className="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    {showcaseProduct.brand}
                  </span>
                </div>

                {/* Hero Image */}
                <div 
                  onClick={() => navigateTo('product-detail', { product: showcaseProduct })}
                  className="relative aspect-16/10 rounded-xl overflow-hidden bg-slate-950 flex items-center justify-center cursor-pointer"
                >
                  <img
                    src={showcaseProduct.image}
                    alt={showcaseProduct.name}
                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent" />
                  
                  {/* Floating Specs Pill */}
                  <div className="absolute bottom-3 left-3 right-3 flex items-center justify-between text-xs text-slate-200">
                    <span className="font-semibold">{showcaseProduct.name}</span>
                    <span className="text-blue-400 font-bold">${showcaseProduct.price.toFixed(2)}</span>
                  </div>
                </div>

                {/* Spec badges grid */}
                <div className="grid grid-cols-2 gap-2 mt-4 text-xs">
                  <div className="p-2.5 rounded-lg bg-slate-800/60 border border-slate-700/50">
                    <div className="text-[10px] text-slate-400 uppercase font-bold">Processor</div>
                    <div className="font-semibold text-slate-200 truncate">{showcaseProduct.specs.cpu}</div>
                  </div>
                  <div className="p-2.5 rounded-lg bg-slate-800/60 border border-slate-700/50">
                    <div className="text-[10px] text-slate-400 uppercase font-bold">Graphics Card</div>
                    <div className="font-semibold text-blue-400 truncate">{showcaseProduct.specs.gpu}</div>
                  </div>
                  <div className="p-2.5 rounded-lg bg-slate-800/60 border border-slate-700/50">
                    <div className="text-[10px] text-slate-400 uppercase font-bold">Memory & SSD</div>
                    <div className="font-semibold text-slate-200 truncate">{showcaseProduct.specs.ram}</div>
                  </div>
                  <div className="p-2.5 rounded-lg bg-slate-800/60 border border-slate-700/50">
                    <div className="text-[10px] text-slate-400 uppercase font-bold">Display Panel</div>
                    <div className="font-semibold text-slate-200 truncate">{showcaseProduct.specs.display}</div>
                  </div>
                </div>

                {/* View Product CTA */}
                <button
                  onClick={() => navigateTo('product-detail', { product: showcaseProduct })}
                  className="w-full mt-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition-colors flex items-center justify-center gap-1.5 cursor-pointer"
                >
                  <span>{lang === 'km' ? 'ពិនិត្យមើលលម្អិត' : 'View Machine Details'}</span>
                  <ArrowRight className="w-3.5 h-3.5" />
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  );
};
