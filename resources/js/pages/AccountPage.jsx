import React, { useState } from 'react';
import { 
  User, Package, Heart, MapPin, ShieldCheck, LogOut, 
  ExternalLink, ChevronRight, ShoppingBag, Trash2 
} from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { mockOrders, productsData } from '../data/mockData';

export const AccountPage = ({ initialTab = 'orders' }) => {
  const { t, wishlist, toggleWishlist, addToCart, navigateTo, lang } = useShop();
  const [activeTab, setActiveTab] = useState(initialTab);

  const wishlistedProducts = productsData.filter(p => wishlist.includes(p.id));

  return (
    <div className="py-8 bg-[#F8FAFC]">
      <div className="max-w-7xl mx-auto px-4">
        {/* Account Header */}
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div className="flex items-center gap-4">
            <div className="w-16 h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-bold text-2xl shadow-md shadow-blue-600/20">
              SM
            </div>
            <div>
              <div className="text-xs text-slate-400 font-medium">{t.account.greeting}</div>
              <h1 className="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                Sophea Mean
              </h1>
              <div className="text-xs text-slate-500 font-mono mt-0.5">
                +855 12 345 678 • Verified Customer
              </div>
            </div>
          </div>

          <div className="flex items-center gap-2">
            <button
              onClick={() => navigateTo('shop')}
              className="px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-xl text-xs font-bold transition-colors cursor-pointer"
            >
              Browse Shop
            </button>
          </div>
        </div>

        {/* Dashboard Grid */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
          
          {/* Navigation Sidebar (3 cols) */}
          <div className="lg:col-span-3">
            <div className="bg-white border border-slate-200 rounded-3xl p-3 shadow-xs space-y-1">
              {[
                { id: 'orders', label: t.account.tabs.orders, icon: Package, count: mockOrders.length },
                { id: 'wishlist', label: t.account.tabs.wishlist, icon: Heart, count: wishlist.length },
                { id: 'profile', label: t.account.tabs.profile, icon: User },
                { id: 'addresses', label: t.account.tabs.addresses, icon: MapPin },
                { id: 'warranty', label: t.account.tabs.warranty, icon: ShieldCheck },
              ].map((tab) => {
                const Icon = tab.icon;
                const isActive = activeTab === tab.id;
                return (
                  <button
                    key={tab.id}
                    onClick={() => setActiveTab(tab.id)}
                    className={`w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-bold transition-colors cursor-pointer ${
                      isActive
                        ? 'bg-blue-600 text-white shadow-sm'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                    }`}
                  >
                    <div className="flex items-center gap-2.5">
                      <Icon className="w-4 h-4" />
                      <span>{tab.label}</span>
                    </div>
                    {tab.count !== undefined && (
                      <span className={`text-[10px] px-1.5 py-0.5 rounded-full ${
                        isActive ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600'
                      }`}>
                        {tab.count}
                      </span>
                    )}
                  </button>
                );
              })}
            </div>
          </div>

          {/* Main Content Area (9 cols) */}
          <div className="lg:col-span-9 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs">
            
            {/* 1. Orders Tab */}
            {activeTab === 'orders' && (
              <div className="space-y-6">
                <div>
                  <h2 className="text-lg font-bold text-slate-900">{t.account.recentOrders}</h2>
                  <p className="text-xs text-slate-500">Track and manage your previous computer and component orders.</p>
                </div>

                <div className="space-y-4">
                  {mockOrders.map(order => (
                    <div key={order.id} className="border border-slate-200 rounded-2xl p-4 sm:p-5 hover:border-slate-300 transition-colors">
                      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100 text-xs">
                        <div className="flex items-center gap-2">
                          <span className="font-mono font-bold text-slate-900">{order.code}</span>
                          <span className="text-slate-400">•</span>
                          <span className="text-slate-500">{order.date}</span>
                        </div>
                        <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 self-start sm:self-auto">
                          {order.status}
                        </span>
                      </div>

                      <div className="py-3 divide-y divide-slate-100">
                        {order.items.map((item, idx) => (
                          <div key={idx} className="py-2 first:pt-0 last:pb-0 flex items-center justify-between text-xs">
                            <div className="flex items-center gap-3">
                              <img
                                src={item.image}
                                alt={item.name}
                                className="w-12 h-12 object-cover rounded-lg border border-slate-200"
                              />
                              <div>
                                <div className="font-semibold text-slate-900">{item.name}</div>
                                <div className="text-slate-400">Qty: {item.quantity} • ${item.price.toFixed(2)}</div>
                              </div>
                            </div>
                            <div className="font-black text-slate-900">
                              ${(item.price * item.quantity).toFixed(2)}
                            </div>
                          </div>
                        ))}
                      </div>

                      <div className="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <div>
                          <span className="text-slate-400">Total:</span>{' '}
                          <span className="font-black text-blue-600">${order.total.toFixed(2)}</span>
                        </div>

                        <button
                          onClick={() => navigateTo('track', { code: order.code })}
                          className="flex items-center gap-1 text-blue-600 font-bold hover:underline cursor-pointer"
                        >
                          <span>{t.account.viewOrder}</span>
                          <ChevronRight className="w-4 h-4" />
                        </button>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {/* 2. Wishlist Tab */}
            {activeTab === 'wishlist' && (
              <div className="space-y-6">
                <div>
                  <h2 className="text-lg font-bold text-slate-900">{t.account.tabs.wishlist} ({wishlistedProducts.length})</h2>
                  <p className="text-xs text-slate-500">Products you have saved for later.</p>
                </div>

                {wishlistedProducts.length === 0 ? (
                  <div className="py-12 text-center space-y-3">
                    <Heart className="w-12 h-12 text-slate-300 mx-auto" />
                    <p className="text-xs text-slate-500">Your wishlist is currently empty.</p>
                    <button
                      onClick={() => navigateTo('shop')}
                      className="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold cursor-pointer"
                    >
                      Browse Products
                    </button>
                  </div>
                ) : (
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {wishlistedProducts.map(p => (
                      <div key={p.id} className="border border-slate-200 rounded-2xl p-4 flex gap-3 relative group">
                        <img
                          src={p.image}
                          alt={p.name}
                          className="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0"
                        />
                        <div className="flex-1 min-w-0 flex flex-col justify-between">
                          <div>
                            <span className="text-[10px] font-bold text-blue-600 uppercase">{p.brand}</span>
                            <h4 className="text-xs font-bold text-slate-900 line-clamp-1">{p.name}</h4>
                            <div className="text-xs font-black text-blue-600 mt-1">${p.price.toFixed(2)}</div>
                          </div>
                          <div className="flex items-center gap-2 mt-2">
                            <button
                              onClick={() => addToCart(p, 1)}
                              className="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold flex items-center gap-1 cursor-pointer"
                            >
                              <ShoppingBag className="w-3.5 h-3.5" />
                              <span>Add to Cart</span>
                            </button>
                            <button
                              onClick={() => toggleWishlist(p)}
                              className="p-1.5 text-slate-400 hover:text-red-500 cursor-pointer"
                              title="Remove"
                            >
                              <Trash2 className="w-3.5 h-3.5" />
                            </button>
                          </div>
                        </div>
                      </div>
                    ))}
                  </div>
                )}
              </div>
            )}

            {/* 3. Profile Tab */}
            {activeTab === 'profile' && (
              <div className="space-y-6 max-w-xl">
                <div>
                  <h2 className="text-lg font-bold text-slate-900">Personal Information</h2>
                  <p className="text-xs text-slate-500">Update your contact information for faster checkout.</p>
                </div>

                <div className="space-y-4 text-xs">
                  <div>
                    <label className="font-semibold text-slate-700 block mb-1">Full Name</label>
                    <input
                      type="text"
                      defaultValue="Sophea Mean"
                      className="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl"
                    />
                  </div>
                  <div>
                    <label className="font-semibold text-slate-700 block mb-1">Phone Number (+855)</label>
                    <input
                      type="text"
                      defaultValue="012 345 678"
                      className="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-mono"
                    />
                  </div>
                  <div>
                    <label className="font-semibold text-slate-700 block mb-1">Email Address</label>
                    <input
                      type="email"
                      defaultValue="sophea.mean@example.com"
                      className="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl"
                    />
                  </div>
                  <button className="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold cursor-pointer hover:bg-blue-700">
                    Save Changes
                  </button>
                </div>
              </div>
            )}

            {/* 4. Saved Addresses */}
            {activeTab === 'addresses' && (
              <div className="space-y-4">
                <div>
                  <h2 className="text-lg font-bold text-slate-900">{t.account.tabs.addresses}</h2>
                  <p className="text-xs text-slate-500">Your default Cambodian delivery destination.</p>
                </div>

                <div className="p-4 rounded-2xl border-2 border-blue-600 bg-blue-50/30 text-xs space-y-2 max-w-md">
                  <div className="flex justify-between font-bold text-slate-900">
                    <span>Home (Default)</span>
                    <span className="text-blue-600">Active</span>
                  </div>
                  <p className="text-slate-600">
                    Street 271, House #14B, Sangkat Teuk Thla, Khan Sen Sok, Phnom Penh, Cambodia
                  </p>
                  <p className="text-slate-500 font-mono">Contact: 012 345 678</p>
                </div>
              </div>
            )}

            {/* 5. Warranty Claims */}
            {activeTab === 'warranty' && (
              <div className="space-y-4">
                <div>
                  <h2 className="text-lg font-bold text-slate-900">{t.account.tabs.warranty}</h2>
                  <p className="text-xs text-slate-500">Track official manufacturer warranty for your registered items.</p>
                </div>

                <div className="border border-slate-200 rounded-2xl p-4 space-y-3 text-xs">
                  <div className="flex items-center justify-between">
                    <span className="font-bold text-slate-900">ASUS ROG Strix G16</span>
                    <span className="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded font-bold">Active Warranty</span>
                  </div>
                  <div className="text-slate-500">
                    Serial: ROG-882410-KH • Registered: Sept 24, 2026
                  </div>
                  <div className="text-slate-600">
                    Expires: Sept 24, 2028 (2 Years Official ASUS Cambodia Coverage)
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
