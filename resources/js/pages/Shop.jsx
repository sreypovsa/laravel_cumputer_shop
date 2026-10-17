import React, { useState, useMemo } from 'react';
import { FilterSidebar } from '../components/FilterSidebar';
import { ProductCard } from '../components/ProductCard';
import { useShop } from '../context/ShopContext';
import { productsData } from '../data/mockData';
import { SlidersHorizontal, ArrowUpDown, X, ChevronRight } from 'lucide-react';

export const Shop = ({ initialCategory = '' }) => {
  const { t, searchQuery, setSearchQuery, lang } = useShop();

  const [filters, setFilters] = useState({
    category: initialCategory,
    brands: [],
    minPrice: '',
    maxPrice: '',
    cpus: [],
    gpus: [],
    rams: [],
    inStockOnly: false
  });

  const [sortBy, setSortBy] = useState('featured');
  const [mobileFilterOpen, setMobileFilterOpen] = useState(false);

  const resetFilters = () => {
    setFilters({
      category: '',
      brands: [],
      minPrice: '',
      maxPrice: '',
      cpus: [],
      gpus: [],
      rams: [],
      inStockOnly: false
    });
    setSearchQuery('');
  };

  // Filter & sort logic
  const filteredProducts = useMemo(() => {
    return productsData
      .filter(p => {
        // Search query
        if (searchQuery.trim()) {
          const q = searchQuery.toLowerCase();
          const matchName = p.name.toLowerCase().includes(q);
          const matchBrand = p.brand.toLowerCase().includes(q);
          const matchCpu = p.specs.cpu?.toLowerCase().includes(q);
          const matchGpu = p.specs.gpu?.toLowerCase().includes(q);
          if (!matchName && !matchBrand && !matchCpu && !matchGpu) return false;
        }

        // Category
        if (filters.category && p.category !== filters.category) {
          return false;
        }

        // Brands
        if (filters.brands.length > 0 && !filters.brands.includes(p.brand)) {
          return false;
        }

        // Min Price
        if (filters.minPrice !== '' && p.price < Number(filters.minPrice)) {
          return false;
        }

        // Max Price
        if (filters.maxPrice !== '' && p.price > Number(filters.maxPrice)) {
          return false;
        }

        // CPU
        if (filters.cpus.length > 0) {
          const hasCpu = filters.cpus.some(c => p.specs.cpu?.toLowerCase().includes(c.toLowerCase()));
          if (!hasCpu) return false;
        }

        // GPU
        if (filters.gpus.length > 0) {
          const hasGpu = filters.gpus.some(g => p.specs.gpu?.toLowerCase().includes(g.toLowerCase()));
          if (!hasGpu) return false;
        }

        // Stock
        if (filters.inStockOnly && p.stockStatus !== 'inStock') {
          return false;
        }

        return true;
      })
      .sort((a, b) => {
        if (sortBy === 'price-asc') return a.price - b.price;
        if (sortBy === 'price-desc') return b.price - a.price;
        if (sortBy === 'newest') return (b.isNew ? 1 : 0) - (a.isNew ? 1 : 0);
        if (sortBy === 'popular') return b.reviewsCount - a.reviewsCount;
        return (b.isFeatured ? 1 : 0) - (a.isFeatured ? 1 : 0);
      });
  }, [productsData, filters, sortBy, searchQuery]);

  return (
    <div className="py-8 bg-[#F8FAFC]">
      <div className="max-w-7xl mx-auto px-4">
        {/* Breadcrumb & Header */}
        <div className="mb-6">
          <div className="flex items-center gap-1.5 text-xs text-slate-400 mb-2">
            <span>Home</span>
            <ChevronRight className="w-3.5 h-3.5" />
            <span className="text-slate-800 font-semibold">{t.shop.title}</span>
          </div>
          
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <h1 className="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {t.shop.title}
              </h1>
              <p className="text-xs sm:text-sm text-slate-500 mt-1">
                {searchQuery ? `Searching for "${searchQuery}" • ` : ''}
                {filteredProducts.length} {t.shop.resultsCount}
              </p>
            </div>

            {/* Sort & Mobile Filter Trigger */}
            <div className="flex items-center gap-3">
              {/* Mobile Filter Button */}
              <button
                type="button"
                onClick={() => setMobileFilterOpen(true)}
                className="lg:hidden flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 shadow-xs cursor-pointer"
              >
                <SlidersHorizontal className="w-4 h-4 text-blue-600" />
                <span>{t.shop.filterBtn}</span>
              </button>

              {/* Sort By Dropdown */}
              <div className="flex items-center gap-2 bg-white border border-slate-300 rounded-xl px-3 py-1.5 shadow-xs">
                <ArrowUpDown className="w-3.5 h-3.5 text-slate-400" />
                <label className="text-xs font-medium text-slate-500 hidden sm:inline">
                  {t.shop.sortBy}:
                </label>
                <select
                  value={sortBy}
                  onChange={(e) => setSortBy(e.target.value)}
                  className="text-xs font-semibold text-slate-800 bg-transparent focus:outline-none cursor-pointer"
                >
                  <option value="featured">{t.shop.sortFeatured}</option>
                  <option value="newest">{t.shop.sortNewest}</option>
                  <option value="price-asc">{t.shop.sortPriceAsc}</option>
                  <option value="price-desc">{t.shop.sortPriceDesc}</option>
                  <option value="popular">{t.shop.sortPopular}</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        {/* Layout: Sidebar + Product Grid */}
        <div className="grid grid-cols-1 lg:grid-cols-4 gap-6">
          {/* Desktop Left Sidebar */}
          <div className="hidden lg:block lg:col-span-1">
            <FilterSidebar
              filters={filters}
              setFilters={setFilters}
              onResetFilters={resetFilters}
            />
          </div>

          {/* Right Product Grid */}
          <div className="lg:col-span-3">
            {filteredProducts.length === 0 ? (
              <div className="bg-white border border-slate-200 rounded-2xl p-12 text-center space-y-4">
                <div className="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                  <SlidersHorizontal className="w-8 h-8" />
                </div>
                <h3 className="text-base font-bold text-slate-900">
                  {t.shop.noProducts}
                </h3>
                <p className="text-xs text-slate-500 max-w-sm mx-auto">
                  Try clearing your filters or search keywords to see all genuine products.
                </p>
                <button
                  onClick={resetFilters}
                  className="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-colors cursor-pointer"
                >
                  {t.shop.resetFilters}
                </button>
              </div>
            ) : (
              <div className="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-5">
                {filteredProducts.map(p => (
                  <ProductCard key={p.id} product={p} />
                ))}
              </div>
            )}
          </div>
        </div>
      </div>

      {/* Mobile Filter Sheet */}
      {mobileFilterOpen && (
        <div className="fixed inset-0 z-50 flex lg:hidden">
          <div
            className="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"
            onClick={() => setMobileFilterOpen(false)}
          />
          <div className="relative ml-auto w-full max-w-xs bg-white h-full shadow-2xl flex flex-col z-10 overflow-y-auto p-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
              <span className="font-bold text-slate-900 text-sm">{t.shop.filterBtn}</span>
              <button
                onClick={() => setMobileFilterOpen(false)}
                className="p-1 text-slate-400 hover:text-slate-700"
              >
                <X className="w-5 h-5" />
              </button>
            </div>
            <FilterSidebar
              filters={filters}
              setFilters={setFilters}
              onResetFilters={resetFilters}
            />
            <div className="mt-6">
              <button
                onClick={() => setMobileFilterOpen(false)}
                className="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold"
              >
                Apply Filters ({filteredProducts.length} Results)
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};
