import React, { useState } from 'react';
import { ShopProvider, useShop } from './context/ShopContext';
import { TopBar } from './components/TopBar';
import { Header } from './components/Header';
import { Navigation } from './components/Navigation';
import { Footer } from './components/Footer';
import { CartDrawer } from './components/CartDrawer';
import { QuickViewModal } from './components/QuickViewModal';
import { ToastContainer } from './components/Toast';
import { MobileBottomNav } from './components/MobileBottomNav';

// Pages
import { Home } from './pages/Home';
import { Shop } from './pages/Shop';
import { ProductDetails } from './pages/ProductDetails';
import { CartPage } from './pages/CartPage';
import { CheckoutPage } from './pages/CheckoutPage';
import { TrackOrderPage } from './pages/TrackOrderPage';
import { AccountPage } from './pages/AccountPage';

const MainLayout = () => {
  const { activePage, selectedCategory } = useShop();
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  return (
    <div className="min-h-screen flex flex-col bg-[#F8FAFC] text-[#111827] selection:bg-blue-600 selection:text-white pb-14 lg:pb-0">
      {/* 1. Top Announcement Bar */}
      <TopBar />

      {/* 2. Main Header with Search & Cart */}
      <Header onOpenMobileMenu={() => setMobileMenuOpen(true)} />

      {/* 3. Category & Navigation Bar */}
      <Navigation
        mobileMenuOpen={mobileMenuOpen}
        onCloseMobileMenu={() => setMobileMenuOpen(false)}
      />

      {/* 4. Active Page Router */}
      <main className="flex-1">
        {activePage === 'home' && <Home />}
        {activePage === 'shop' && <Shop />}
        {activePage === 'category' && <Shop initialCategory={selectedCategory} />}
        {activePage === 'product-detail' && <ProductDetails />}
        {activePage === 'cart' && <CartPage />}
        {activePage === 'checkout' && <CheckoutPage />}
        {activePage === 'track' && <TrackOrderPage />}
        {activePage === 'account' && <AccountPage />}
      </main>

      {/* 5. Dark Navy Footer */}
      <Footer />

      {/* Modals & Overlays */}
      <CartDrawer />
      <QuickViewModal />
      <ToastContainer />
      <MobileBottomNav />
    </div>
  );
};

export const QuickTechApp = () => {
  return (
    <ShopProvider>
      <MainLayout />
    </ShopProvider>
  );
};

export default QuickTechApp;
