import React from 'react';
import { Hero } from '../components/Hero';
import { TrustFeatures } from '../components/TrustFeatures';
import { CategoryGrid } from '../components/CategoryGrid';
import { ProductGrid } from '../components/ProductGrid';
import { BrandSection } from '../components/BrandSection';
import { useShop } from '../context/ShopContext';
import { productsData } from '../data/mockData';
import { ArrowRight, Wrench, ShieldAlert, Cpu } from 'lucide-react';

export const Home = () => {
  const { t, navigateTo, lang } = useShop();

  // Top Laptops & Gaming rigs
  const topLaptops = productsData.filter(
    p => p.category === 'gaming-laptops' || p.category === 'laptops'
  );

  // PC Components
  const pcComponents = productsData.filter(
    p => p.category === 'pc-components'
  );

  return (
    <div className="space-y-4">
      {/* 1. Hero Section */}
      <Hero />

      {/* 2. Trust Badges */}
      <TrustFeatures />

      {/* 3. Category Grid */}
      <CategoryGrid />

      {/* 4. Top Laptops & Gaming Machines */}
      <ProductGrid
        title={t.featured.title}
        subtitle={t.featured.subtitle}
        products={topLaptops}
        onExplore={() => navigateTo('category', { category: 'gaming-laptops' })}
        exploreLabel={t.featured.exploreBtn}
        columns="4"
      />

      {/* Promotional Custom PC Build Banner */}
      <section className="max-w-7xl mx-auto px-4 py-4">
        <div className="relative rounded-2xl bg-gradient-to-r from-blue-900 via-indigo-950 to-slate-900 text-white p-6 sm:p-8 md:p-10 overflow-hidden shadow-xl border border-blue-500/20">
          <div className="relative z-10 max-w-xl space-y-3">
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold uppercase tracking-wider">
              <Cpu className="w-3.5 h-3.5" />
              <span>{lang === 'km' ? 'សេវាកម្មផ្គុំ PC ជំនាញ' : 'Custom PC Building Service'}</span>
            </div>
            <h3 className="text-xl sm:text-2xl md:text-3xl font-black tracking-tight leading-tight">
              {lang === 'km' 
                ? 'ផ្គុំកុំព្យូទ័រតាមតម្រូវការ ជាមួយអ្នកជំនាញបច្ចេកទេស QuickTech'
                : 'Need a Custom Gaming or AI Workstation Built for You?'}
            </h3>
            <p className="text-slate-300 text-xs sm:text-sm leading-relaxed">
              {lang === 'km'
                ? 'យើងមានសេវាកម្មប្រឹក្សាឥតគិតថ្លៃ ដំឡើងប្រព័ន្ធត្រជាក់ រៀបចំខ្សែស្អាត និងតេស្តម៉ាស៊ីន Stress Test មុនពេលប្រគល់ជូន។'
                : 'Free assembly, professional cable management, and 24-hour benchmark testing before nationwide delivery.'}
            </p>
            <div className="pt-2">
              <button
                onClick={() => navigateTo('category', { category: 'pc-components' })}
                className="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-lg shadow-blue-600/30 cursor-pointer"
              >
                <span>{t.componentsSection.viewAllBtn}</span>
                <ArrowRight className="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </section>

      {/* 5. PC Components Section */}
      <ProductGrid
        title={t.componentsSection.title}
        subtitle={t.componentsSection.subtitle}
        products={pcComponents}
        onExplore={() => navigateTo('category', { category: 'pc-components' })}
        exploreLabel={t.componentsSection.viewAllBtn}
        columns="3"
      />

      {/* 6. Brand Partners */}
      <BrandSection />
    </div>
  );
};
