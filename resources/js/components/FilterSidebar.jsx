import React, { useState } from 'react';
import { ChevronDown, SlidersHorizontal, RotateCcw, Check } from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { categoriesData, brandsData } from '../data/mockData';

export const FilterSidebar = ({
  filters,
  setFilters,
  onResetFilters
}) => {
  const { t, lang } = useShop();

  const [expandedSections, setExpandedSections] = useState({
    categories: true,
    brands: true,
    price: true,
    cpu: true,
    gpu: true,
    ram: true,
    availability: true
  });

  const toggleSection = (section) => {
    setExpandedSections(prev => ({ ...prev, [section]: !prev[section] }));
  };

  const cpuOptions = ['Intel Core i9', 'Intel Core i7', 'Intel Core i5', 'AMD Ryzen 7', 'Apple M3'];
  const gpuOptions = ['RTX 4070', 'RTX 4060', 'RTX 4050', 'RTX 3050', 'Apple 14-core'];
  const ramOptions = ['32GB', '18GB', '16GB', '8GB'];

  const handleCategoryToggle = (slug) => {
    setFilters(prev => ({
      ...prev,
      category: prev.category === slug ? '' : slug
    }));
  };

  const handleBrandToggle = (brandName) => {
    setFilters(prev => {
      const exists = prev.brands.includes(brandName);
      return {
        ...prev,
        brands: exists
          ? prev.brands.filter(b => b !== brandName)
          : [...prev.brands, brandName]
      };
    });
  };

  const handleCpuToggle = (cpu) => {
    setFilters(prev => {
      const exists = prev.cpus.includes(cpu);
      return {
        ...prev,
        cpus: exists ? prev.cpus.filter(c => c !== cpu) : [...prev.cpus, cpu]
      };
    });
  };

  const handleGpuToggle = (gpu) => {
    setFilters(prev => {
      const exists = prev.gpus.includes(gpu);
      return {
        ...prev,
        gpus: exists ? prev.gpus.filter(g => g !== gpu) : [...prev.gpus, gpu]
      };
    });
  };

  const handleRamToggle = (ram) => {
    setFilters(prev => {
      const exists = prev.rams.includes(ram);
      return {
        ...prev,
        rams: exists ? prev.rams.filter(r => r !== ram) : [...prev.rams, ram]
      };
    });
  };

  return (
    <div className="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-6">
      {/* Header */}
      <div className="flex items-center justify-between pb-4 border-b border-slate-200">
        <div className="flex items-center gap-2 font-bold text-slate-900 text-sm">
          <SlidersHorizontal className="w-4 h-4 text-blue-600" />
          <span>{t.shop.filterBtn}</span>
        </div>
        <button
          onClick={onResetFilters}
          className="text-xs text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1 cursor-pointer"
        >
          <RotateCcw className="w-3 h-3" />
          <span>{t.shop.clearAll}</span>
        </button>
      </div>

      {/* 1. Category Filter */}
      <div className="border-b border-slate-100 pb-4">
        <button
          type="button"
          onClick={() => toggleSection('categories')}
          className="w-full flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-800 mb-3 cursor-pointer"
        >
          <span>{t.filters.categories}</span>
          <ChevronDown className={`w-4 h-4 transition-transform ${expandedSections.categories ? 'rotate-180' : ''}`} />
        </button>

        {expandedSections.categories && (
          <div className="space-y-1.5">
            {categoriesData.map(cat => (
              <label
                key={cat.id}
                className="flex items-center justify-between text-xs text-slate-600 hover:text-blue-600 cursor-pointer py-1 px-1.5 rounded hover:bg-slate-50 transition-colors"
              >
                <div className="flex items-center gap-2">
                  <input
                    type="checkbox"
                    checked={filters.category === cat.slug}
                    onChange={() => handleCategoryToggle(cat.slug)}
                    className="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500"
                  />
                  <span>{lang === 'km' ? cat.name_km : cat.name}</span>
                </div>
                <span className="text-[11px] text-slate-400 font-medium">({cat.count})</span>
              </label>
            ))}
          </div>
        )}
      </div>

      {/* 2. Price Range */}
      <div className="border-b border-slate-100 pb-4">
        <button
          type="button"
          onClick={() => toggleSection('price')}
          className="w-full flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-800 mb-3 cursor-pointer"
        >
          <span>{t.filters.priceRange}</span>
          <ChevronDown className={`w-4 h-4 transition-transform ${expandedSections.price ? 'rotate-180' : ''}`} />
        </button>

        {expandedSections.price && (
          <div className="space-y-3">
            <div className="flex items-center gap-2">
              <div className="flex-1">
                <label className="text-[10px] text-slate-400 block mb-1">{t.filters.minPrice}</label>
                <input
                  type="number"
                  value={filters.minPrice}
                  onChange={(e) => setFilters(prev => ({ ...prev, minPrice: Number(e.target.value) }))}
                  placeholder="0"
                  className="w-full px-2.5 py-1.5 text-xs border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500"
                />
              </div>
              <span className="text-slate-400 mt-4">-</span>
              <div className="flex-1">
                <label className="text-[10px] text-slate-400 block mb-1">{t.filters.maxPrice}</label>
                <input
                  type="number"
                  value={filters.maxPrice}
                  onChange={(e) => setFilters(prev => ({ ...prev, maxPrice: Number(e.target.value) }))}
                  placeholder="2500"
                  className="w-full px-2.5 py-1.5 text-xs border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500"
                />
              </div>
            </div>
          </div>
        )}
      </div>

      {/* 3. Brands */}
      <div className="border-b border-slate-100 pb-4">
        <button
          type="button"
          onClick={() => toggleSection('brands')}
          className="w-full flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-800 mb-3 cursor-pointer"
        >
          <span>{t.filters.brands}</span>
          <ChevronDown className={`w-4 h-4 transition-transform ${expandedSections.brands ? 'rotate-180' : ''}`} />
        </button>

        {expandedSections.brands && (
          <div className="space-y-1.5 max-h-48 overflow-y-auto pr-1">
            {brandsData.map(brand => (
              <label
                key={brand.name}
                className="flex items-center justify-between text-xs text-slate-600 hover:text-blue-600 cursor-pointer py-1 px-1.5 rounded hover:bg-slate-50 transition-colors"
              >
                <div className="flex items-center gap-2">
                  <input
                    type="checkbox"
                    checked={filters.brands.includes(brand.name)}
                    onChange={() => handleBrandToggle(brand.name)}
                    className="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500"
                  />
                  <span>{brand.name}</span>
                </div>
              </label>
            ))}
          </div>
        )}
      </div>

      {/* 4. Processor (CPU) */}
      <div className="border-b border-slate-100 pb-4">
        <button
          type="button"
          onClick={() => toggleSection('cpu')}
          className="w-full flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-800 mb-3 cursor-pointer"
        >
          <span>{t.filters.cpu}</span>
          <ChevronDown className={`w-4 h-4 transition-transform ${expandedSections.cpu ? 'rotate-180' : ''}`} />
        </button>

        {expandedSections.cpu && (
          <div className="space-y-1.5">
            {cpuOptions.map(cpu => (
              <label
                key={cpu}
                className="flex items-center text-xs text-slate-600 hover:text-blue-600 cursor-pointer py-1 px-1.5 rounded hover:bg-slate-50 gap-2"
              >
                <input
                  type="checkbox"
                  checked={filters.cpus.includes(cpu)}
                  onChange={() => handleCpuToggle(cpu)}
                  className="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500"
                />
                <span>{cpu}</span>
              </label>
            ))}
          </div>
        )}
      </div>

      {/* 5. Graphics (GPU) */}
      <div className="border-b border-slate-100 pb-4">
        <button
          type="button"
          onClick={() => toggleSection('gpu')}
          className="w-full flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-800 mb-3 cursor-pointer"
        >
          <span>{t.filters.gpu}</span>
          <ChevronDown className={`w-4 h-4 transition-transform ${expandedSections.gpu ? 'rotate-180' : ''}`} />
        </button>

        {expandedSections.gpu && (
          <div className="space-y-1.5">
            {gpuOptions.map(gpu => (
              <label
                key={gpu}
                className="flex items-center text-xs text-slate-600 hover:text-blue-600 cursor-pointer py-1 px-1.5 rounded hover:bg-slate-50 gap-2"
              >
                <input
                  type="checkbox"
                  checked={filters.gpus.includes(gpu)}
                  onChange={() => handleGpuToggle(gpu)}
                  className="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500"
                />
                <span>{gpu}</span>
              </label>
            ))}
          </div>
        )}
      </div>

      {/* 6. Availability */}
      <div>
        <button
          type="button"
          onClick={() => toggleSection('availability')}
          className="w-full flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-800 mb-3 cursor-pointer"
        >
          <span>{t.filters.availability}</span>
          <ChevronDown className={`w-4 h-4 transition-transform ${expandedSections.availability ? 'rotate-180' : ''}`} />
        </button>

        {expandedSections.availability && (
          <label className="flex items-center gap-2 text-xs text-slate-600 hover:text-blue-600 cursor-pointer py-1 px-1.5 rounded hover:bg-slate-50">
            <input
              type="checkbox"
              checked={filters.inStockOnly}
              onChange={(e) => setFilters(prev => ({ ...prev, inStockOnly: e.target.checked }))}
              className="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500"
            />
            <span>{t.filters.inStockOnly}</span>
          </label>
        )}
      </div>
    </div>
  );
};
