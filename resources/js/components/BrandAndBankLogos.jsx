import React from 'react';

/* =========================================================================
   1. LANGUAGE FLAGS (Cambodia 🇰🇭, United Kingdom 🇬🇧, USA 🇺🇸)
   ========================================================================= */

// Official Cambodian National Flag (Blue / Red / Blue with Angkor Wat)
export const CambodiaFlag = ({ className = "w-5 h-3.5", rounded = "rounded-xs" }) => (
  <svg
    viewBox="0 0 50 32"
    className={`${className} ${rounded} shadow-xs inline-block shrink-0`}
    xmlns="http://www.w3.org/2000/svg"
  >
    {/* Blue top and bottom bands (1/4 each) */}
    <rect width="50" height="8" fill="#032EA6" />
    <rect y="24" width="50" height="8" fill="#032EA6" />
    {/* Red middle band (1/2) */}
    <rect y="8" width="50" height="16" fill="#ED1B24" />
    {/* Angkor Wat Silhouette in white */}
    <g fill="#FFFFFF" transform="translate(14, 10) scale(0.44)">
      {/* Base towers and temple silhouette */}
      <path d="M 2 24 L 48 24 L 48 20 L 44 20 L 44 14 L 41 14 L 41 10 L 37 10 L 37 6 L 35 6 L 35 4 L 33 4 L 33 2 L 31 2 L 31 4 L 29 4 L 29 6 L 27 6 L 27 10 L 23 10 L 23 14 L 20 14 L 20 20 L 16 20 L 16 14 L 13 14 L 13 10 L 9 10 L 9 6 L 7 6 L 7 4 L 5 4 L 5 2 L 3 2 L 3 4 L 1 4 L 1 6 L -1 6 L -1 10 L -5 10 L -5 14 L -8 14 L -8 20 L -12 20 L -12 24 Z" />
      <polygon points="25,-2 22,2 28,2" />
      <rect x="23" y="2" width="4" height="6" />
      <polygon points="11,2 8,6 14,6" />
      <polygon points="39,2 36,6 42,6" />
      <rect x="5" y="18" width="4" height="6" fill="#ED1B24" />
      <rect x="23" y="16" width="4" height="8" fill="#ED1B24" />
      <rect x="41" y="18" width="4" height="6" fill="#ED1B24" />
    </g>
  </svg>
);

// UK Flag (Union Jack)
export const UkFlag = ({ className = "w-5 h-3.5", rounded = "rounded-xs" }) => (
  <svg
    viewBox="0 0 60 36"
    className={`${className} ${rounded} shadow-xs inline-block shrink-0`}
    xmlns="http://www.w3.org/2000/svg"
  >
    <clipPath id="uk-clip">
      <rect width="60" height="36" />
    </clipPath>
    <g clipPath="url(#uk-clip)">
      <rect width="60" height="36" fill="#012169" />
      {/* Diagonals */}
      <path d="M0,0 L60,36 M60,0 L0,36" stroke="#FFFFFF" strokeWidth="6" />
      <path d="M0,0 L60,36" stroke="#C8102E" strokeWidth="2" strokeDasharray="30 30" strokeDashoffset="0" />
      <path d="M60,0 L0,36" stroke="#C8102E" strokeWidth="2" strokeDasharray="30 30" strokeDashoffset="0" />
      {/* Central Cross */}
      <path d="M30,0 v36 M0,18 h60" stroke="#FFFFFF" strokeWidth="10" />
      <path d="M30,0 v36 M0,18 h60" stroke="#C8102E" strokeWidth="6" />
    </g>
  </svg>
);


/* =========================================================================
   2. CAMBODIAN BANK & PAYMENT LOGOS (ABA, ACLEDA, WING, KHQR, VISA, MC)
   ========================================================================= */

// Official National Bank of Cambodia KHQR Red Badge
export const KhqrLogo = ({ className = "h-6", withLabel = false }) => (
  <div className={`inline-flex items-center gap-1.5 ${className}`}>
    <div className="bg-[#E00025] text-white px-2 py-0.5 rounded font-black text-[11px] tracking-wider shadow-xs flex items-center gap-1 font-mono">
      <span>KHQR</span>
    </div>
    {withLabel && (
      <span className="text-[10px] font-bold text-slate-500 uppercase tracking-tight">
        Bakong NBC
      </span>
    )}
  </div>
);

// ABA Pay / ABA Bank Logo
export const AbaPayLogo = ({ className = "h-7" }) => (
  <svg viewBox="0 0 110 36" className={`${className} w-auto`} xmlns="http://www.w3.org/2000/svg">
    <rect width="110" height="36" rx="6" fill="#005F73" />
    {/* ABA Bold Text */}
    <text x="10" y="24" fontFamily="'Inter', system-ui, sans-serif" fontWeight="900" fontSize="16" fill="#FFFFFF" letterSpacing="1">
      ABA
    </text>
    {/* PAY Pill Badge */}
    <rect x="56" y="8" width="46" height="20" rx="4" fill="#0A9396" />
    <text x="64" y="22" fontFamily="'Inter', system-ui, sans-serif" fontWeight="800" fontSize="11" fill="#FFFFFF" letterSpacing="0.5">
      PAY
    </text>
  </svg>
);

// ACLEDA Mobile Logo
export const AcledaLogo = ({ className = "h-7" }) => (
  <svg viewBox="0 0 120 36" className={`${className} w-auto`} xmlns="http://www.w3.org/2000/svg">
    <rect width="120" height="36" rx="6" fill="#002855" />
    {/* Mythical Bird Golden Circle Emblem */}
    <circle cx="18" cy="18" r="10" fill="#E0A96D" />
    <path d="M14 19 Q18 12 22 17 Q18 20 14 19 Z" fill="#002855" />
    {/* ACLEDA Text */}
    <text x="34" y="23" fontFamily="'Inter', system-ui, sans-serif" fontWeight="800" fontSize="13" fill="#FFFFFF" letterSpacing="0.8">
      ACLEDA
    </text>
  </svg>
);

// Wing Bank KHQR Logo
export const WingLogo = ({ className = "h-7" }) => (
  <svg viewBox="0 0 110 36" className={`${className} w-auto`} xmlns="http://www.w3.org/2000/svg">
    <rect width="110" height="36" rx="6" fill="#00529B" />
    {/* Wing green swoosh symbol */}
    <circle cx="18" cy="18" r="9" fill="#78BE20" />
    <path d="M12 18 C15 13 22 13 24 18 C20 18 16 16 12 18 Z" fill="#00529B" />
    {/* Wing Bank Text */}
    <text x="33" y="23" fontFamily="'Inter', system-ui, sans-serif" fontWeight="900" fontSize="14" fill="#FFFFFF">
      Wing
    </text>
  </svg>
);

// Visa Logo
export const VisaLogo = ({ className = "h-6" }) => (
  <svg viewBox="0 0 80 26" className={`${className} w-auto`} xmlns="http://www.w3.org/2000/svg">
    <rect width="80" height="26" rx="4" fill="#FFFFFF" stroke="#E2E8F0" strokeWidth="1" />
    <text x="14" y="19" fontFamily="'Inter', system-ui, sans-serif" fontWeight="900" fontSize="17" fontStyle="italic" fill="#1A1F71" letterSpacing="0.5">
      VISA
    </text>
    {/* Golden touch on V */}
    <polygon points="14,7 18,7 16,11" fill="#F7B600" />
  </svg>
);

// Mastercard Logo
export const MastercardLogo = ({ className = "h-6" }) => (
  <svg viewBox="0 0 80 26" className={`${className} w-auto`} xmlns="http://www.w3.org/2000/svg">
    <rect width="80" height="26" rx="4" fill="#FFFFFF" stroke="#E2E8F0" strokeWidth="1" />
    {/* Red Circle */}
    <circle cx="34" cy="13" r="8" fill="#EB001B" />
    {/* Orange Circle */}
    <circle cx="46" cy="13" r="8" fill="#F79E1B" opacity="0.9" />
    {/* Intersecting area */}
    <path d="M40 7.7 A 8 8 0 0 0 40 18.3 A 8 8 0 0 0 40 7.7" fill="#FF5F00" />
  </svg>
);


/* =========================================================================
   3. OFFICIAL HARDWARE BRAND LOGOS
   ========================================================================= */

// ASUS Logo
export const AsusLogo = ({ className = "h-6" }) => (
  <svg viewBox="0 0 100 24" className={`${className} w-auto text-slate-800 hover:text-blue-600 transition-colors`} fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <text x="2" y="18" fontFamily="'Inter', system-ui, sans-serif" fontWeight="900" fontSize="19" letterSpacing="2.5">
      ASUS
    </text>
  </svg>
);

// Republic of Gamers (ROG) Logo
export const RogLogo = ({ className = "h-7" }) => (
  <div className={`inline-flex items-center gap-1.5 ${className}`}>
    <svg viewBox="0 0 32 32" className="h-full w-auto text-red-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
      <path d="M16 2 C8.27 2 2 8.27 2 16 C2 23.73 8.27 30 16 30 C23.73 30 30 23.73 30 16 C30 8.27 23.73 2 16 2 Z M23 12 C21 16 17 21 12 24 C14 20 16 15 20 12 Z M9 18 C11 15 15 11 19 9 C17 12 14 16 9 18 Z" />
    </svg>
    <span className="font-black text-sm tracking-wider text-slate-900">ROG</span>
  </div>
);

// MSI Logo
export const MsiLogo = ({ className = "h-6" }) => (
  <svg viewBox="0 0 85 24" className={`${className} w-auto text-slate-900 hover:text-red-600 transition-colors`} fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <text x="2" y="18" fontFamily="'Inter', system-ui, sans-serif" fontWeight="900" fontSize="20" fontStyle="italic" letterSpacing="3">
      msi
    </text>
  </svg>
);

// Acer Logo
export const AcerLogo = ({ className = "h-6" }) => (
  <svg viewBox="0 0 85 24" className={`${className} w-auto text-[#83B81A] hover:opacity-90 transition-opacity`} fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <text x="2" y="18" fontFamily="'Inter', system-ui, sans-serif" fontWeight="800" fontSize="19" letterSpacing="1">
      acer
    </text>
  </svg>
);

// Lenovo Logo
export const LenovoLogo = ({ className = "h-6" }) => (
  <div className={`inline-flex items-center bg-[#E2231A] text-white px-2 py-0.5 rounded-sm font-black text-xs tracking-wider ${className}`}>
    <span>Lenovo</span>
  </div>
);

// Apple Logo
export const AppleLogo = ({ className = "h-6" }) => (
  <svg viewBox="0 0 170 170" className={`${className} w-auto text-slate-900`} fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.69-3.04-7.59-7.71-11.72-14.01-6-9.14-10.74-19.46-14.22-29.96-3.48-10.5-5.22-20.73-5.22-29.69 0-13.59 3.54-24.96 10.63-34.11 7.08-9.15 16.03-13.84 26.84-14.07 5.01 0 10.45 1.34 16.32 4.02 5.88 2.68 9.77 4.07 11.69 4.17 1.45 0 5.41-1.39 11.87-4.17 6.46-2.78 11.96-4.04 16.51-3.79 12.42.63 22.38 5.17 29.87 13.62-10.9 6.64-16.23 15.67-16 27.09.23 9.07 3.65 16.74 10.25 23.01 6.6 6.27 14.54 9.87 23.82 10.79-2.01 6.13-4.44 12.19-7.28 18.17zM119.22 33.72c0-7.39 2.67-14.37 8.01-20.94 5.34-6.57 12-10.87 19.98-12.78.23 1.11.35 2.11.35 3.01 0 7.39-2.8 14.51-8.4 21.36-5.6 6.85-12.23 10.98-19.89 12.39-.02-1.02-.05-2.03-.05-3.04z" />
  </svg>
);

// Intel Logo
export const IntelLogo = ({ className = "h-6" }) => (
  <svg viewBox="0 0 70 24" className={`${className} w-auto text-[#0068B5]`} fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <text x="2" y="18" fontFamily="'Inter', system-ui, sans-serif" fontWeight="900" fontSize="19" letterSpacing="0.5">
      intel
    </text>
  </svg>
);

// AMD Logo
export const AmdLogo = ({ className = "h-6" }) => (
  <div className={`inline-flex items-center gap-1 text-slate-900 ${className}`}>
    {/* Arrow emblem */}
    <svg viewBox="0 0 24 24" className="w-5 h-5 text-emerald-600" fill="currentColor">
      <path d="M3 3h8v8H3z M13 3h8v8h-8z M13 13h8v8h-8z" />
    </svg>
    <span className="font-black text-sm tracking-wider">AMD</span>
  </div>
);

// Cooler Master Logo
export const CoolerMasterLogo = ({ className = "h-6" }) => (
  <div className={`inline-flex items-center gap-1.5 text-purple-900 ${className}`}>
    <div className="w-5 h-5 border-2 border-purple-700 rotate-45 rounded-xs flex items-center justify-center">
      <div className="w-2 h-2 bg-purple-700 -rotate-45" />
    </div>
    <span className="font-extrabold text-xs tracking-tight text-slate-900">COOLER MASTER</span>
  </div>
);

// Kingston Logo
export const KingstonLogo = ({ className = "h-6" }) => (
  <div className={`inline-flex items-center gap-1.5 ${className}`}>
    <div className="w-4 h-5 bg-red-600 rounded-xs flex items-center justify-center text-white font-black text-[10px]">
      K
    </div>
    <span className="font-black text-xs tracking-wider text-slate-900">Kingston</span>
  </div>
);

// Corsair Logo
export const CorsairLogo = ({ className = "h-6" }) => (
  <div className={`inline-flex items-center gap-1.5 ${className}`}>
    <svg viewBox="0 0 24 24" className="w-5 h-5 text-slate-900" fill="currentColor">
      <path d="M12 2 L2 22 L12 18 L22 22 Z" />
    </svg>
    <span className="font-extrabold text-xs tracking-wider text-slate-900">CORSAIR</span>
  </div>
);
