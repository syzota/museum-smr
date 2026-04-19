<?php require_once __DIR__ . '/config/auth.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tentang Museum · Museum Kota Samarinda</title>
<link rel="icon" type="image/png" href="assets/logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Mono:wght@300;400;500&family=Spectral:ital,wght@0,200;0,300;0,400;1,200;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/beranda.css">
<link rel="stylesheet" href="assets/css/tentang.css">

<style>

/* ── PAGE BANNER ─────────────────────── */

:root {
  /* ─── MUSEUM COLOR SCHEME ─── */
  --linen:     #f4ede5;       
  --parchment: #faf6f1;         
  --vellum:    #e8e0d5;         
  --ink:       #3a2e24;        
  --ink-2:     #5a4a3a;        
  --sepia:     #6b5d4f;        
  --sepia-lt:  #9a8d7e;        
  --moss:      #2d7a5e;         
  --rust:      #8b4513;         
  --cream-dk:  #c4b5a0;       
  --dot-col:   rgba(58, 46, 36, 0.06);
  --navy-deep: #1a4a40;        
  --navy-mid:  #256b5c;        
  --navy-soft: #5a9a8a;         
  --paper:     rgba(255,255,255,0.92);
  --pattern-url: url("assets/3.webp"); 

  --serif: 'Cormorant Garamond', Georgia, serif;
  --alt-serif: 'Spectral', Georgia, serif;
  --mono: 'DM Mono', 'Courier New', monospace;

  --page-max: 1280px;
}

.page-banner {
  padding: 64px 0 56px;
  background: linear-gradient(rgba(62,37,8,0.93), rgba(26,74,64,0.93)), var(--pattern-url) center/620px auto repeat;
  border-bottom: 0.5px solid rgba(255,255,255,0.12);
}
.page-banner-inner {
  display: grid;
  grid-template-columns: 1fr auto;
  align-items: end;
  gap: 32px;
}
.page-banner-breadcrumb {
  font-family: var(--mono);
  font-size: 8.5px;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: rgba(196,181,160,0.5);
  margin-bottom: 14px;
  font-weight: 500;
}
.page-banner-title {
  font-family: var(--serif);
  font-size: clamp(40px,5.5vw,72px);
  font-weight: 600;
  line-height: 0.97;
  color: var(--linen);
  letter-spacing: -0.02em;
}
.page-banner-title em { font-style: italic; font-weight: 400; color: rgba(255, 255, 255, 0.82); }
.page-banner-desc {
  font-family: var(--alt-serif);
  font-size: 15px;
  font-weight: 300;
  line-height: 1.78;
  color: rgba(255, 255, 255, 0.8);
  max-width: 480px;
  margin-top: 16px;
}

/* ── STAT BAND ──────────────────────── */
.stat-band {
  background: var(--parchment);
  border-bottom: 0.5px solid rgba(196,181,160,0.45);
  box-shadow: 0 4px 24px rgba(26,74,64,0.06);
}
.stat-band-inner {
  display: grid;
  grid-template-columns: repeat(4,1fr);
}
.stat-band-col {
  padding: 36px 40px;
  border-right: 0.5px solid rgba(196,181,160,0.45);
  text-align: center;
  transition: background 0.2s;
}
.stat-band-col:last-child { border-right: none; }
.stat-band-col:hover { background: rgba(196,181,160,0.08); }
.stat-band-num {
  font-family: var(--serif);
  font-size: 52px;
  font-weight: 600;
  color: var(--ink);
  line-height: 1;
  letter-spacing: -0.02em;
}
.stat-band-label {
  font-family: var(--mono);
  font-size: 8.5px;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--sepia-lt);
  margin-top: 8px;
  font-weight: 500;
}

/* ── SECTION SHARED ─────────────────── */
.t-section {
  background: var(--paper);
  padding: 48px;
  shadow: 0 4px 24px rgba(26,74,64,0.06);
  border-bottom: 0.5px solid rgba(196,181,160,0.4);
}
.t-section-header {
  margin: 48px;
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
  gap: 24px;
  padding: 24px;
  border-bottom: 0.5px solid rgba(196,181,160,0.4);
  border-top: 0.5px solid rgba(196,181,160,0.4);
}
.t-eyebrow {
  font-family: var(--mono);
  font-size: 8.5px;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: var(--moss);
  font-weight: 500;
  margin-bottom: 8px;
  text-align: center;
}
.t-title {
  font-family: var(--serif);
  font-size: clamp(28px,3.5vw,48px);
  font-weight: 600;
  line-height: 1.05;
  color: var(--ink);
  text-align: center;
  letter-spacing: -0.015em;
}
.t-title em { font-style: italic; font-weight: 400; color: var(--navy-mid); }

/* ── SEJARAH GRID ───────────────────── */
.sejarah-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  border-radius: 16px;
  overflow: hidden;
  box-shadow:
    0 2px 8px rgba(26,74,64,0.06),
    0 16px 56px rgba(26,74,64,0.13);
  border: 0.5px solid rgba(196,181,160,0.4);
}
.sejarah-left {
  background: white;
  display: flex;
  flex-direction: column;
}
.card-stack-wrap {
  flex: 1;
  padding: 48px 48px 36px;
  display: flex;
  flex-direction: column;
}

/* Card stack */
.card-stack {
  position: relative;
  flex: 1;
  min-height: 320px;
  cursor: grab;
  user-select: none;
  --dur-swipe: 420ms;
  --dur-return: 320ms;
  --ease-spring: cubic-bezier(0.34,1.56,0.64,1);
  --ease-smooth: cubic-bezier(0.25,1,0.5,1);
}
.card-stack:active { cursor: grabbing; }
.s-card {
  position: absolute;
  inset: 0;
  background: var(--parchment);
  border: 0.5px solid rgba(196,181,160,0.55);
  border-radius: 12px;
  padding: 30px 30px 26px;
  display: flex;
  flex-direction: column;
  gap: 13px;
  box-shadow:
    0 2px 6px rgba(26,74,64,0.05),
    0 10px 28px rgba(26,74,64,0.09);
  overflow: hidden;
  transform:
    translateX(calc(var(--swipe-x,0px) + (var(--i,1)-1)*6px))
    translateY(calc((var(--i,1)-1)*10px))
    scale(calc(1-(var(--i,1)-1)*0.04))
    rotate(var(--swipe-rotate,0deg));
  z-index: calc(10 - var(--i,1));
  will-change: transform;
  transition: transform var(--dur-return) var(--ease-smooth),
              opacity   var(--dur-return) var(--ease-smooth);
}
.s-card.is-dragging { transition: none; }
.s-card.is-leaving  {
  transition: transform var(--dur-swipe) var(--ease-smooth),
              opacity   var(--dur-swipe) var(--ease-smooth);
  opacity: 0; pointer-events: none;
}
.s-card.is-returning {
  transition: transform var(--dur-return) var(--ease-spring),
              opacity   var(--dur-return) var(--ease-spring);
}
.s-card::before {
  content: '← Kembali';
  position: absolute; top: 16px; left: 16px;
  font-family: var(--mono); font-size: 8px; letter-spacing: 0.13em;
  text-transform: uppercase; color: var(--rust);
  border: 0.5px solid currentColor; padding: 3px 9px;
  border-radius: 4px; opacity: 0; transition: opacity 0.15s;
  pointer-events: none;
}
.s-card::after {
  content: 'Lanjut →';
  position: absolute; top: 16px; right: 16px;
  font-family: var(--mono); font-size: 8px; letter-spacing: 0.13em;
  text-transform: uppercase; color: var(--moss);
  border: 0.5px solid currentColor; padding: 3px 9px;
  border-radius: 4px; opacity: 0; transition: opacity 0.15s;
  pointer-events: none;
}
.s-card.drag-left::before  { opacity: 1; }
.s-card.drag-right::after  { opacity: 1; }
.s-card-meta { display: flex; align-items: center; justify-content: space-between; }
.s-card-counter {
  font-family: var(--mono); font-size: 8.5px; letter-spacing: 0.18em;
  text-transform: uppercase; color: var(--sepia-lt); font-weight: 500;
}
.s-card-dots { display: flex; gap: 5px; }
.s-card-dot {
  width: 5px; height: 5px; border-radius: 50%;
  background: rgba(196,181,160,0.55);
  transition: background 0.25s, transform 0.25s;
}
.s-card-dot.active { background: var(--navy-deep); transform: scale(1.2); }
.s-card-title {
  font-family: var(--serif); font-size: 22px; font-weight: 600;
  color: var(--ink); line-height: 1.15; letter-spacing: -0.01em;
}
.s-card-body {
  font-family: var(--alt-serif); font-size: 13.5px; font-weight: 300;
  line-height: 1.85; color: var(--sepia); flex: 1;
}
.s-card-year {
  font-family: var(--serif); font-size: 54px; font-weight: 600;
  color: rgba(196,181,160,0.18); line-height: 1;
  position: absolute; bottom: 14px; right: 22px;
  pointer-events: none; letter-spacing: -0.04em;
}
.stack-hint {
  margin-top: 16px;
  font-family: var(--mono); font-size: 8px; letter-spacing: 0.16em;
  text-transform: uppercase; color: var(--sepia-lt);
  display: flex; align-items: center; gap: 10px; font-weight: 500;
}
.stack-hint::before, .stack-hint::after {
  content: ''; flex: 1; height: 0.5px; background: rgba(196,181,160,0.45);
}

/* Visi right panel */
.sejarah-right {
  background: var(--navy-deep);
  padding: 48px;
  display: flex;
  flex-direction: column;
  gap: 28px;
  position: relative;
  overflow: hidden;
}
.sejarah-right::before {
  content: '';
  position: absolute; inset: 0;
  background: var(--pattern-url) center/480px auto repeat;
  opacity: 0.06; pointer-events: none;
}
.visi-eyebrow {
  font-family: var(--mono); font-size: 8.5px; letter-spacing: 0.22em;
  text-transform: uppercase; color: rgba(196,181,160,0.45);
  font-weight: 500; position: relative;
}
.visi-quote {
  font-family: var(--serif); font-size: 22px; font-weight: 400;
  font-style: italic; color: rgba(244,237,229,0.9); line-height: 1.5;
  padding-left: 20px; border-left: 2px solid rgba(90,154,138,0.55);
  position: relative;
}
.visi-list { display: flex; flex-direction: column; gap: 20px; position: relative; }
.visi-item-title {
  font-family: var(--mono); font-size: 8.5px; letter-spacing: 0.16em;
  text-transform: uppercase; color: var(--navy-soft);
  margin-bottom: 4px; font-weight: 500;
}
.visi-item-body {
  font-family: var(--alt-serif); font-size: 13.5px; font-weight: 300;
  color: rgba(196,181,160,0.68); line-height: 1.75;
}

/* ── SLIDER TIMELINE ────────────────── */
/* Exact recreation of sohrabzia PwPNpad:
   slider scrubs events, content fades
   out-then-in with staggered children,
   tick marks + year labels, era themes */

.timeline-widget {
  background: white;
  border-radius: 20px;
  border: 0.5px solid rgba(196,181,160,0.4);
  box-shadow:
    0 4px 16px rgba(26,74,64,0.06),
    0 24px 64px rgba(26,74,64,0.13);
  padding: 56px 52px 48px;
  overflow: hidden;
  position: relative;
  transition: background 0.6s cubic-bezier(0.4,0,0.2,1);
}
/* Era backgrounds */
.tw-era-founding{background:linear-gradient(135deg,var(--parchment) 0%,var(--vellum) 100%);}
.tw-era-growth{background:linear-gradient(135deg,var(--linen) 0%,var(--cream-dk) 100%);}
.tw-era-education{background:linear-gradient(135deg,#eef3f1 0%,#d6e5df 100%);}
.tw-era-modern{background:linear-gradient(135deg,#f6efe6 0%,#e6d8c3 100%);}
.tw-era-digital{background:linear-gradient(135deg,#f3f0ec 0%,#ddd4c8 100%);}
.tw-era-future{background:linear-gradient(135deg,#edf6f2 0%,#cfe8df 100%);}

.tw-header { text-align: center; margin-bottom: 44px; }
.tw-header-title {
  font-family: var(--serif); font-size: clamp(26px,3vw,40px);
  font-weight: 600; color: var(--ink); letter-spacing: -0.02em; line-height: 1.1;
  opacity: 0; animation: tw-title-in 0.9s cubic-bezier(0.22,1,0.36,1) forwards;
}
.tw-header-title em { font-style: italic; font-weight: 400; color: var(--navy-mid); }
.tw-header-sub {
  font-family: var(--alt-serif); font-size: 14.5px; font-weight: 300;
  color: var(--sepia); margin-top: 6px;
  opacity: 0; animation: tw-title-in 0.9s cubic-bezier(0.22,1,0.36,1) 0.18s forwards;
}
@keyframes tw-title-in {
  from { opacity:0; transform:translateY(28px); }
  60%  { opacity:1; transform:translateY(-4px); }
  to   { opacity:1; transform:translateY(0); }
}

/* Content */
.tw-content {
  min-height: 300px;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  text-align: center; gap: 14px;
  margin-bottom: 52px;
}
.tw-icon {
  width: 76px; height: 76px; border-radius: 20px;
  display: flex; align-items: center; justify-content: center;
  font-size: 2rem; margin-bottom: 6px;
  transition: all 0.5s cubic-bezier(0.4,0,0.2,1);
  box-shadow: 0 12px 32px rgba(0,0,0,0.15);
}
/* Icon colours per era */
.tw-era-founding  .tw-icon { background: linear-gradient(135deg,#2d7a5e,#1a4a40); box-shadow: 0 12px 32px rgba(45,122,94,0.28); }
.tw-era-growth    .tw-icon { background: linear-gradient(135deg,#8b4513,#6b3410); box-shadow: 0 12px 32px rgba(139,69,19,0.28); }
.tw-era-education .tw-icon { background: linear-gradient(135deg,#4361b8,#2c44a0); box-shadow: 0 12px 32px rgba(46, 33, 5, 0.28); }
.tw-era-modern    .tw-icon { background: linear-gradient(135deg,#d97706,#b45309); box-shadow: 0 12px 32px rgba(217,119,6,0.28); }
.tw-era-digital   .tw-icon { background: linear-gradient(135deg,#7c3aed,#5b21b6); box-shadow: 0 12px 32px rgba(9, 70, 45, 0.52); }
.tw-era-future    .tw-icon { background: linear-gradient(135deg,#059669,#047857); box-shadow: 0 12px 32px rgba(5,150,105,0.28); }

.tw-year {
  font-family: var(--serif); font-size: 4rem; font-weight: 600;
  line-height: 1; letter-spacing: -0.04em; color: rgba(0,0,0,0.52);
}
.tw-title {
  font-family: var(--serif); font-size: 1.6rem; font-weight: 600;
  color: rgba(0,0,0,0.72); letter-spacing: -0.02em; line-height: 1.2;
}
.tw-desc {
  font-family: var(--alt-serif); font-size: 1rem; font-weight: 300;
  max-width: 540px; line-height: 1.78; color: rgba(0,0,0,0.5);
}

/* Slider area */
.tw-slider-area { position: relative; padding: 0 4px; }
.tw-track {
  position: relative; height: 6px;
  background: rgba(0,0,0,0.1); border-radius: 8px;
  margin-bottom: 20px; user-select: none;
}
.tw-progress {
  position: absolute; top: 0; left: 0;
  height: 6px; border-radius: 8px; width: 0%;
  transition: width 0.4s cubic-bezier(0.4,0,0.2,1);
}
/* Progress per era */
.tw-era-founding  .tw-progress { background: linear-gradient(90deg,#2d7a5e,#1a4a40); }
.tw-era-growth    .tw-progress { background: linear-gradient(90deg,#8b4513,#6b3410); }
.tw-era-education .tw-progress { background: linear-gradient(90deg,#4361b8,#2c44a0); }
.tw-era-modern    .tw-progress { background: linear-gradient(90deg,#d97706,#b45309); }
.tw-era-digital   .tw-progress { background: linear-gradient(90deg,#7c3aed,#5b21b6); }
.tw-era-future    .tw-progress { background: linear-gradient(90deg,#059669,#047857); }

.tw-tick {
  position: absolute; top: -4px;
  width: 2px; height: 14px;
  background: rgba(0,0,0,0.15); border-radius: 1px;
  transform: translateX(-1px);
  transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}
.tw-tick.active { height: 18px; top: -6px; width: 3px; }
.tw-era-founding  .tw-tick.active { background: #2d7a5e; box-shadow: 0 0 8px rgba(45,122,94,0.4); }
.tw-era-growth    .tw-tick.active { background: #8b4513; box-shadow: 0 0 8px rgba(139,69,19,0.4); }
.tw-era-education .tw-tick.active { background: #9a4215; box-shadow: 0 0 8px rgba(116, 108, 53, 0.4); }
.tw-era-modern    .tw-tick.active { background: #d97706; box-shadow: 0 0 8px rgba(217,119,6,0.4); }
.tw-era-digital   .tw-tick.active { background: #0f4112; box-shadow: 0 0 8px rgba(47, 89, 24, 0.4); }
.tw-era-future    .tw-tick.active { background: #059669; box-shadow: 0 0 8px rgba(5,150,105,0.4); }

.tw-input {
  -webkit-appearance: none; appearance: none;
  position: absolute; top: 4px; left: 0;
  width: 100%; height: 6px;
  background: transparent; outline: none;
  cursor: pointer; z-index: 10; margin: 0;
}
.tw-input::-webkit-slider-thumb {
  -webkit-appearance: none; appearance: none;
  width: 22px; height: 22px; border-radius: 50%;
  background: white; border: 3px solid #2d7a5e;
  cursor: pointer; margin-top: -8px;
  box-shadow: 0 4px 14px rgba(0,0,0,0.18);
  transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}
.tw-input::-webkit-slider-thumb:hover {
  transform: scale(1.18);
  box-shadow: 0 6px 20px rgba(0,0,0,0.22), 0 0 0 8px rgba(45,122,94,0.12);
}
.tw-input::-moz-range-thumb {
  width: 22px; height: 22px; border-radius: 50%;
  background: white; border: 3px solid #2d7a5e;
  box-shadow: 0 4px 14px rgba(0,0,0,0.18);
}
/* Thumb per era */
.tw-era-founding  .tw-input::-webkit-slider-thumb,
.tw-era-founding  .tw-input::-moz-range-thumb  { border-color: #2d7a5e; }
.tw-era-growth    .tw-input::-webkit-slider-thumb,
.tw-era-growth    .tw-input::-moz-range-thumb  { border-color: #8b4513; }
.tw-era-education .tw-input::-webkit-slider-thumb,
.tw-era-education .tw-input::-moz-range-thumb  { border-color: #473a0f; }
.tw-era-modern    .tw-input::-webkit-slider-thumb,
.tw-era-modern    .tw-input::-moz-range-thumb  { border-color: #d97706; }
.tw-era-digital   .tw-input::-webkit-slider-thumb,
.tw-era-digital   .tw-input::-moz-range-thumb  { border-color: #1e3615; }
.tw-era-future    .tw-input::-webkit-slider-thumb,
.tw-era-future    .tw-input::-moz-range-thumb  { border-color: #059669; }

.tw-labels {
  position: relative; height: 22px; padding: 0 2px;
}
.tw-label {
  position: absolute;
  font-family: var(--mono); font-size: 8.5px;
  letter-spacing: 0.1em; color: rgba(0,0,0,0.32);
  font-weight: 500; transform: translateX(-50%);
  white-space: nowrap;
  transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
  cursor: pointer;
}
.tw-label.active { font-weight: 700; transform: translateX(-50%) scale(1.1); }
.tw-era-founding  .tw-label.active { color: #2d7a5e; }
.tw-era-growth    .tw-label.active { color: #8b4513; }
.tw-era-education .tw-label.active { color: #1a3d08; }
.tw-era-modern    .tw-label.active { color: #d97706; }
.tw-era-digital   .tw-label.active { color: #4e3a13; }
.tw-era-future    .tw-label.active { color: #059669; }

/* Fade animations — exact from pen */
.tw-fade-out {
  animation: tw-out 0.32s cubic-bezier(0.4,0,0.2,1) forwards;
}
.tw-fade-in {
  animation: tw-in 0.48s cubic-bezier(0.22,1,0.36,1) forwards;
}
.tw-content .tw-fade-in:nth-child(1) { animation-delay: 0s;    }
.tw-content .tw-fade-in:nth-child(2) { animation-delay: 0.08s; }
.tw-content .tw-fade-in:nth-child(3) { animation-delay: 0.16s; }
.tw-content .tw-fade-in:nth-child(4) { animation-delay: 0.24s; }

@keyframes tw-out {
  from { opacity:1; transform:translateY(0); }
  40%  { transform:translateY(6px); }
  to   { opacity:0; transform:translateY(20px); }
}
@keyframes tw-in {
  from { opacity:0; transform:translateY(-18px); }
  60%  { opacity:1; transform:translateY(3px); }
  to   { opacity:1; transform:translateY(0); }
}

/* ── TEAM ───────────────────────────── */
.team-grid {
  display: grid;
  grid-template-columns: repeat(3,1fr);
  gap: 24px;
  background: var(--parchment);
  border-radius: 16px;
  box-shadow:
    0 2px 8px rgba(26,74,64,0.05),
    0 10px 32px rgba(26,74,64,0.08);
}
.team-card {
  background: white;
  border-radius: 16px;
  border: 0.5px solid rgba(196,181,160,0.4);
  padding: 32px 28px 28px;
  display: flex; flex-direction: column; gap: 14px;
  box-shadow:
    0 2px 8px rgba(26,74,64,0.05),
    0 10px 32px rgba(26,74,64,0.08);
  transition:
    transform 0.35s cubic-bezier(0.34,1.56,0.64,1),
    box-shadow 0.3s ease,
    opacity 0.5s ease;
  opacity: 0;
  transform: translateY(20px);
}
.team-card.tc-visible { opacity: 1; transform: translateY(0); }
.team-card:nth-child(1) { transition-delay: 0.05s; }
.team-card:nth-child(2) { transition-delay: 0.15s; }
.team-card:nth-child(3) { transition-delay: 0.25s; }
.team-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 4px 16px rgba(26,74,64,0.07), 0 24px 56px rgba(26,74,64,0.14);
}
.team-avatar {
  width: 60px; height: 60px; border-radius: 16px;
  background: linear-gradient(135deg,var(--parchment),var(--vellum));
  border: 0.5px solid rgba(196,181,160,0.45);
  display: flex; align-items: center; justify-content: center;
  font-family: var(--serif); font-size: 24px; font-weight: 600;
  color: var(--navy-deep);
  box-shadow: 0 4px 12px rgba(26,74,64,0.09);
}
.team-role {
  font-family: var(--mono); font-size: 8.5px; letter-spacing: 0.16em;
  text-transform: uppercase; color: rgba(244,237,229,0.9);
  background: var(--navy-deep); padding: 5px 14px;
  border-radius: 40px; width: fit-content; font-weight: 500;
}
.team-name {
  font-family: var(--serif); font-size: 24px; font-weight: 600;
  color: var(--ink); line-height: 1.1; letter-spacing: -0.01em;
}
.team-bio {
  font-family: var(--alt-serif); font-size: 13.5px;
  font-weight: 300; line-height: 1.72; color: var(--sepia);
}

/* ── RESPONSIVE ─────────────────────── */
@media (max-width: 980px) {
  .sejarah-grid { grid-template-columns: 1fr; }
  .sejarah-right { padding: 40px 32px; }
  .card-stack-wrap { padding: 36px 32px 28px; }
  .stat-band-inner { grid-template-columns: repeat(2,1fr); }
  .team-grid { grid-template-columns: 1fr; gap: 16px; }
  .timeline-widget { padding: 36px 24px 32px; }
  .page-banner-inner { grid-template-columns: 1fr; }
  .page-banner-year { display: none; }
}
@media (max-width: 640px) {
  .stat-band-inner { grid-template-columns: 1fr; }
  .stat-band-col { border-right: none; border-bottom: 0.5px solid rgba(196,181,160,0.4); }
  .card-stack-wrap { padding: 28px 22px 20px; }
  .tw-year { font-size: 3rem; }
  .tw-title { font-size: 1.25rem; }
  .tw-desc { font-size: 0.95rem; }
  .timeline-widget { padding: 28px 20px 28px; }
}

/* ─── TOPBAR ─── */
.topbar { border-bottom:0.5px solid rgba(196,181,160,0.3); background:linear-gradient(rgba(62,37,8,0.94),rgba(62,37,8,0.94)),var(--pattern-url) center/540px auto repeat; backdrop-filter:blur(8px); position:sticky; top:0; z-index:200; }
.topbar-inner { display:flex; align-items:center; justify-content:space-between; height:42px; gap:24px; }
.topbar-left,.topbar-right { display:flex; align-items:center; gap:20px; }
.topbar-item { font-family:var(--mono); font-size:9px; letter-spacing:0.14em; text-transform:uppercase; color:var(--sepia); transition:color 0.2s; cursor:pointer; background:none; border:none; }
.topbar-item:hover { color:var(--linen); }
.topbar-sep { width:1px; height:14px; background:var(--cream-dk); opacity:0.4; }

/* ─── MASTHEAD ─── */
.masthead { border-bottom:0.5px solid rgba(255,255,255,0.15); padding:32px 0 28px; background:linear-gradient(rgba(62,37,8,0.94),rgba(26,74,64,0.94)),var(--pattern-url) center/620px auto repeat; color:var(--linen); }
.masthead-inner { display:grid; grid-template-columns:1fr auto 1fr; align-items:center; gap:32px; }
.masthead-left { display:flex; flex-direction:column; gap:4px; }
.masthead-right { display:flex; flex-direction:column; align-items:flex-end; gap:8px; }
.masthead-center { text-align:center; }
.museum-name { font-family:var(--serif); font-size:clamp(28px,4vw,52px); font-weight:500; letter-spacing:0.02em; line-height:1; color:var(--linen); cursor:pointer; }
.museum-name em { font-style:italic; font-weight:400; }
.museum-sub { font-family:var(--mono); font-size:9px; letter-spacing:0.22em; text-transform:uppercase; color:rgba(244,237,229,0.72); margin-top:8px; display:flex; align-items:center; justify-content:center; gap:12px; }
.museum-sub::before,.museum-sub::after { content:''; display:block; width:40px; height:0.5px; background:rgba(244,237,229,0.32); }
.search-form { display:flex; align-items:center; border:0.5px solid rgba(255,255,255,0.3); background:rgba(255,255,255,0.08); overflow:hidden; width:200px; border-radius:var(--radius-sm); transition:width 0.3s, border-color 0.2s; }
.search-form:focus-within { border-color:rgba(255,255,255,0.7); background:rgba(255,255,255,0.12); width:240px; }
.search-input { background:transparent; border:none; outline:none; font-family:var(--mono); font-size:9px; letter-spacing:0.12em; color:var(--linen); padding:7px 12px; width:100%; }
.search-input::placeholder { color:rgba(244,237,229,0.62); }
.search-btn { background:transparent; border:none; border-left:0.5px solid rgba(255,255,255,0.22); padding:7px 10px; cursor:pointer; color:var(--linen); font-size:12px; }

/* ─── NAVBAR ─── */
.navbar { border-bottom:0.5px solid rgba(255,255,255,0.15); background:linear-gradient(rgba(62,37,8,0.94),rgba(62,37,8,0.94)),var(--pattern-url) center/540px auto repeat; backdrop-filter:blur(10px); }
.navbar-inner { display:flex; align-items:center; justify-content:center; height:46px; }
.nav-item { font-family:var(--mono); font-size:9.5px; letter-spacing:0.16em; text-transform:uppercase; color:rgba(244,237,229,0.76); padding:0 18px; height:100%; display:flex; align-items:center; border-right:0.5px solid rgba(255,255,255,0.12); transition:background 0.2s, color 0.2s; cursor:pointer; background:none; border-top:none; border-bottom:none; border-left:none; font-weight:500; }
.nav-item:first-child { border-left:0.5px solid rgba(255,255,255,0.12); }
.nav-item:hover { background:rgba(255,255,255,0.1); color:var(--linen); }
.nav-item.active { background:rgba(255,255,255,0.14); color:var(--linen); }

/* ─── FOOTER ─── */
.footer {
  background:
    linear-gradient(rgba(70, 29, 7, 0.97), rgba(26,74,64,0.97)),
    var(--pattern-url) center/620px auto repeat;
  border-top:0.5px solid rgba(255,255,255,0.18);
  padding:48px 0 32px;
}
.footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:48px; padding-bottom:40px; border-bottom:0.5px solid rgba(255,255,255,0.18); }
.footer-name { font-family:var(--serif); font-size:22px; font-weight:300; color:var(--linen); line-height:1.1; margin-bottom:10px; }
.footer-addr { font-family:var(--alt-serif); font-size:13px; font-weight:300; line-height:1.7; color:rgba(244,237,229,0.72); }
.footer-col-title { font-family:var(--mono); font-size:9px; letter-spacing:0.16em; text-transform:uppercase; color:var(--linen); margin-bottom:14px; }
.footer-links { display:flex; flex-direction:column; gap:8px; align-items:flex-start; }
.footer-link { font-family:var(--alt-serif); font-size:13px; font-weight:300; color:rgba(244,237,229,0.72); text-decoration:none; transition:color 0.2s; cursor:pointer; background:none; border:none; text-align:left; }
.footer-link:hover { color:#ffffff; }
.footer-bottom { display:flex; justify-content:space-between; align-items:center; padding-top:24px; }
.footer-copy { font-family:var(--mono); font-size:9px; letter-spacing:0.12em; text-transform:uppercase; color:rgba(244,237,229,0.55); }

/* ─── GLOBAL TOPBAR & SIDEBAR ─── */
.global-topbar { display:flex; }
.global-sidebar { display:flex; }
.global-sidebar-backdrop { display:block; }
.global-topbar { position:sticky; top:0; z-index:320; height:56px; align-items:center; justify-content:space-between; gap:16px; padding:0 24px; background:linear-gradient(rgba(62,37,8,0.94),rgba(62,37,8,0.94)),var(--pattern-url) center/520px auto repeat; border-bottom:0.5px solid rgba(255,255,255,0.15); box-shadow:0 10px 24px rgba(26,74,64,0.12); }
.global-topbar-brand { display:flex; align-items:center; gap:14px; }
.global-menu-toggle { width:34px; height:34px; border:0.5px solid rgba(255,255,255,0.28); background:rgba(255,255,255,0.06); color:var(--linen); display:flex; align-items:center; justify-content:center; cursor:pointer; border-radius:var(--radius-sm); }
.global-menu-toggle-lines { width:14px; height:10px; display:grid; align-content:space-between; }
.global-menu-toggle-lines span { display:block; height:1px; background:currentColor; }
.global-brand-title { font-family:var(--serif); font-size:18px; font-weight:500; color:var(--linen); white-space:nowrap; }
.global-brand-title em { color:rgba(244,237,229,0.65); font-weight:400; }
.global-topbar-meta { font-family:var(--mono); font-size:8px; letter-spacing:0.22em; text-transform:uppercase; color:rgba(244,237,229,0.48); white-space:nowrap; }
.global-sidebar-backdrop { position:fixed; top:56px; right:0; bottom:0; left:0; background:rgba(26,74,64,0.24); backdrop-filter:blur(4px); opacity:0; pointer-events:none; transition:opacity 0.25s; z-index:329; }
.global-sidebar { position:fixed; top:0; left:0; bottom:0; width:min(320px,88vw); flex-direction:column; background:linear-gradient(180deg,rgba(255,255,255,0.98),rgba(244,237,229,0.98)); border-right:0.5px solid rgba(196,181,160,0.95); box-shadow:14px 0 36px rgba(26,74,64,0.12); transform:translateX(-100%); transition:transform 0.28s; z-index:330; }
body.sidebar-open .global-sidebar-backdrop { opacity:1; pointer-events:auto; }
body.sidebar-open .global-sidebar { transform:translateX(0); }
.global-sidebar-head { padding:24px 24px 18px; border-bottom:0.5px solid rgba(196,181,160,0.8); }
.global-sidebar-row { display:flex; align-items:flex-start; justify-content:space-between; gap:14px; }
.global-sidebar-avatar { width:46px; height:46px; border:0.5px solid var(--cream-dk); display:flex; align-items:center; justify-content:center; font-family:var(--serif); font-size:22px; color:var(--navy-deep); background:#fff; border-radius:50%; }
.global-sidebar-close { width:34px; height:34px; border:0.5px solid var(--cream-dk); background:#fff; color:var(--navy-deep); cursor:pointer; border-radius:var(--radius-sm); }
.global-sidebar-title { font-family:var(--serif); font-size:28px; font-weight:600; color:var(--navy-deep); margin-top:16px; }
.global-sidebar-subtitle { font-family:var(--mono); font-size:8px; letter-spacing:0.22em; text-transform:uppercase; color:var(--sepia-lt); margin-top:6px; }
.global-sidebar-section { padding:16px 24px 10px; font-family:var(--mono); font-size:8px; letter-spacing:0.2em; text-transform:uppercase; color:var(--sepia-lt); font-weight:500; }
.global-sidebar-nav { display:flex; flex-direction:column; gap:4px; padding-bottom:12px; }
.global-sidebar-link { display:flex; align-items:center; gap:12px; padding:11px 24px 11px 28px; border-left:4px solid transparent; font-family:var(--mono); font-size:10px; letter-spacing:0.16em; text-transform:uppercase; color:var(--sepia); text-decoration:none; transition:background 0.2s, color 0.2s, border-color 0.2s; font-weight:500; }
.global-sidebar-link:hover { background:rgba(45,122,94,0.08); color:var(--navy-deep); }
.global-sidebar-link.active { background:rgba(45,122,94,0.12); border-left-color:var(--navy-mid); color:var(--navy-deep); }
.global-sidebar-icon { width:16px; text-align:center; font-size:11px; color:var(--navy-soft); }
.global-sidebar-badge { margin-left:auto; min-width:18px; padding:2px 5px; border-radius:999px; background:rgba(45,122,94,0.12); font-family:var(--mono); font-size:8px; color:var(--navy-deep); text-align:center; }
.global-sidebar-actions { margin-top:auto; padding:18px 24px 24px; border-top:0.5px solid rgba(196,181,160,0.8); display:flex; flex-direction:column; gap:12px; }
.global-sidebar-btn { width:100%; font-family:var(--mono); font-size:9px; letter-spacing:0.18em; text-transform:uppercase; padding:14px 16px; cursor:pointer; transition:background 0.2s, color 0.2s; border-radius:var(--radius-sm); font-weight:500; }
.global-sidebar-btn.primary { background:var(--navy-deep); color:var(--linen); border:0.5px solid var(--navy-deep); }
.global-sidebar-btn.primary:hover { background:var(--navy-mid); }
.global-sidebar-btn.ghost { background:transparent; color:var(--sepia); border:0.5px solid var(--cream-dk); }
.global-sidebar-btn.ghost:hover { background:#fff; color:var(--navy-deep); }


</style>
</head>
<body>

<?php require_once __DIR__ . '/templates/global/topbar.php'; ?>
<?php require_once __DIR__ . '/templates/global/sidebar.php'; ?>

<header class="masthead">
  <div class="container">
    <div class="masthead-inner">
      <div class="masthead-left">
        <span style="font-family:var(--mono);font-size:9px;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,0.65);font-weight:500;">Est. 2003 · Samarinda</span>
        <span style="font-family:var(--alt-serif);font-size:12.5px;font-weight:300;color:rgba(244,237,229,0.68);margin-top:2px;">Kalimantan Timur, Indonesia</span>
      </div>
      <div class="masthead-center">
        <div class="museum-name" onclick="location.href='home.php'">Museum <em>Kota</em><br>Samarinda</div>
        <div class="museum-sub">Arsip Sejarah &amp; Kebudayaan</div>
      </div>
      <div class="masthead-right">
        <form class="search-form" action="koleksi.php" method="GET">
          <input class="search-input" type="text" name="q" placeholder="Cari koleksi…" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
          <button class="search-btn" type="submit">⌕</button>
        </form>
        <span style="font-family:var(--alt-serif);font-size:12px;font-weight:300;color:rgba(244,237,229,0.58);">Jl. Bhayangkara No.1, Samarinda</span>
      </div>
    </div>
  </div>
</header>

<nav class="navbar">
  <div class="container">
    <div class="navbar-inner">
      <button class="nav-item"        onclick="location.href='home.php'">Beranda</button>
      <button class="nav-item active" onclick="location.href='tentang.php'">Tentang Museum</button>
      <button class="nav-item"        onclick="location.href='koleksi.php'">Koleksi</button>
      <button class="nav-item"        onclick="location.href='event.php'">Event &amp; Kegiatan</button>
      <button class="nav-item"        onclick="location.href='berita.php'">Berita</button>
      <button class="nav-item"        onclick="location.href='peta.php'">Peta Lokasi</button>
      <button class="nav-item"        onclick="location.href='peminjaman.php'">Peminjaman Ruang</button>
      <button class="nav-item"        onclick="location.href='ulasan.php'">Ulasan</button>
    </div>
  </div>
</nav>

<div class="ticker">
  <div class="ticker-inner">
    <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Pameran Baru: Warisan Dayak Kalimantan Timur</div>
    <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Event: Diskusi Sejarah Samarinda · 22 Maret 2025</div>
    <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Koleksi Baru: Naskah Kuno Abad ke-17</div>
    <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Ruang Seminar Tersedia untuk Peminjaman</div>
    <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Jam Operasional: Selasa–Minggu, 08:00–16:00 WIB</div>
    <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Pameran Baru: Warisan Dayak Kalimantan Timur</div>
    <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Event: Diskusi Sejarah Samarinda · 22 Maret 2025</div>
    <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Koleksi Baru: Naskah Kuno Abad ke-17</div>
    <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Ruang Seminar Tersedia untuk Peminjaman</div>
    <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Jam Operasional: Selasa–Minggu, 08:00–16:00 WIB</div>
  </div>
</div>

<div id="page-tentang" class="page active">

  <!-- BANNER -->
  <div class="page-banner">
    <div class="container">
      <div class="page-banner-inner">
        <div>
          <div class="page-banner-breadcrumb">Museum Kota Samarinda / Tentang Museum</div>
          <h1 class="page-banner-title">Tentang <em>Museum</em></h1>
          <p class="page-banner-desc">Mengenal sejarah, visi, dan dedikasi kami dalam menjaga warisan budaya kota Samarinda untuk generasi mendatang.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- STAT BAND -->
  <div class="stat-band">
    <div class="container" style="display:contents;">
      <div class="stat-band-inner" style="padding:0 40px;">
        <div class="stat-band-col"><div class="stat-band-num">1.247</div><div class="stat-band-label">Artefak Terdokumentasi</div></div>
        <div class="stat-band-col"><div class="stat-band-num">22</div><div class="stat-band-label">Tahun Beroperasi</div></div>
        <div class="stat-band-col"><div class="stat-band-num">12</div><div class="stat-band-label">Ruang Pameran</div></div>
        <div class="stat-band-col"><div class="stat-band-num">48k</div><div class="stat-band-label">Pengunjung Pertahun</div></div>
      </div>
    </div>
  </div>

  <!-- SEJARAH & VISI -->
  <section class="t-section">
    <div class="container">
      <div class="t-section-header">
        <div>
          <div class="t-eyebrow">Profil Institusi</div>
          <h2 class="t-title">Sejarah &amp; <em>Visi</em></h2>
        </div>
      </div>
      <div class="sejarah-grid">
        <div class="sejarah-left">
          <div class="card-stack-wrap">
            <div class="card-stack" id="card-stack" tabindex="0" role="region" aria-label="Sejarah museum">
              <!-- JS builds cards here -->
            </div>
            <p class="stack-hint">Seret atau geser untuk membaca selanjutnya</p>
          </div>
        </div>
        <div class="sejarah-right">
          <div class="visi-eyebrow">Visi &amp; Misi</div>
          <div class="visi-quote">"Menjadi pusat referensi sejarah dan kebudayaan Kalimantan Timur yang terpercaya, inklusif, dan berkelanjutan."</div>
          <div class="visi-list">
            <div>
              <div class="visi-item-title">Pelestarian</div>
              <div class="visi-item-body">Mengumpulkan, merawat, dan mendokumentasikan artefak sejarah dan budaya secara sistematis sesuai standar museum nasional.</div>
            </div>
            <div>
              <div class="visi-item-title">Edukasi</div>
              <div class="visi-item-body">Menyediakan program pembelajaran yang relevan bagi pelajar, mahasiswa, peneliti, dan masyarakat umum tentang sejarah lokal Kalimantan Timur.</div>
            </div>
            <div>
              <div class="visi-item-title">Aksesibilitas</div>
              <div class="visi-item-body">Membuka pintu museum untuk semua kalangan secara gratis, dan mengembangkan katalog digital agar koleksi dapat diakses dari mana saja.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- LINIMASA: slider timeline -->
  <section class="t-section" style="background:var(--parchment);">
    <div class="container">
      <div class="t-section-header">
        <div>
          <div class="t-eyebrow">Kronologi</div>
          <h2 class="t-title">Linimasa <em>Perkembangan</em></h2>
        </div>
      </div>

      <div class="timeline-widget tw-era-founding" id="timelineWidget">
        <div class="tw-header">
          <div class="tw-header-title">Perjalanan <em>Museum</em></div>
          <div class="tw-header-sub">Geser slider untuk menjelajahi setiap tonggak sejarah</div>
        </div>

        <div class="tw-content" id="tw-content">
          <div class="tw-icon"  id="tw-icon">⛦</div>
          <div class="tw-year"  id="tw-year">2003</div>
          <div class="tw-title" id="tw-title">Pendirian Museum</div>
          <div class="tw-desc"  id="tw-desc">Museum Kota Samarinda resmi dibuka oleh Walikota Samarinda pada 17 Agustus 2003. Koleksi awal terdiri dari 287 artefak yang disumbangkan oleh warga dan instansi pemerintah.</div>
        </div>

        <div class="tw-slider-area">
          <div class="tw-track" id="tw-track">
            <div class="tw-progress" id="tw-progress"></div>
          </div>
          <input type="range" class="tw-input" id="tw-slider" min="0" max="5" value="0" step="1" aria-label="Linimasa">
          <div class="tw-labels" id="tw-labels"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- CREATIVE SQUAD -->
  <section class="t-section">
    <div class="container">
      <div class="t-section-header">
        <div>
          <div class="t-eyebrow">The Core Circle</div>
          <h2 class="t-title">Creative <em>Squad</em></h2>
        </div>
      </div>
      <div class="team-grid">
        <div class="team-card">
          <div class="team-avatar">P</div>
          <div class="team-role">The Visionary</div>
          <div class="team-name">Putri</div>
          <div class="team-bio">The Curator of Vibes. Yang pegang kendali; full-stack dan tetep on-track, punya <i>proper exposure</i>.</div>
        </div>
        <div class="team-card">
          <div class="team-avatar">H</div>
          <div class="team-role">The Architect</div>
          <div class="team-name">Hendri</div>
          <div class="team-bio">Logic behind the lore. Ngurusin restorasi artefak dan data archival biar tetep solid dan terstruktur.</div>
        </div>
        <div class="team-card">
          <div class="team-avatar">N</div>
          <div class="team-role">Designer</div>
          <div class="team-name">Narendra</div>
          <div class="team-bio">Experience makers. Nerjemahin sejarah jadi konten digital 3D dan story yang gampang dikonsumsi publik.</div>
        </div>
      </div>
    </div>
  </section>

</div>

<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-name">Museum <em>Kota</em><br>Samarinda</div>
        <div class="footer-addr">Jl. Bhayangkara No.1<br>Samarinda 75121<br>Kalimantan Timur, Indonesia<br><br>© 2025 Museum Kota Samarinda</div>
      </div>
      <div>
        <div class="footer-col-title">Navigasi</div>
        <div class="footer-links">
          <button class="footer-link" onclick="location.href='home.php'">Beranda</button>
          <button class="footer-link" onclick="location.href='tentang.php'">Tentang Museum</button>
          <button class="footer-link" onclick="location.href='koleksi.php'">Koleksi Digital</button>
          <button class="footer-link" onclick="location.href='event.php'">Event &amp; Kegiatan</button>
          <button class="footer-link" onclick="location.href='berita.php'">Berita</button>
        </div>
      </div>
      <div>
        <div class="footer-col-title">Layanan</div>
        <div class="footer-links">
          <button class="footer-link" onclick="location.href='peminjaman.php'">Peminjaman Ruang</button>
          <button class="footer-link" onclick="location.href='event.php'">Program Edukasi</button>
          <button class="footer-link" onclick="location.href='peta.php'">Peta Lokasi</button>
          <button class="footer-link" onclick="location.href='ulasan.php'">Tulis Ulasan</button>
        </div>
      </div>
      <div>
        <div class="footer-col-title">Informasi</div>
        <div class="footer-links">
          <button class="footer-link" onclick="location.href='peta.php'">Jam &amp; Tiket</button>
          <button class="footer-link" onclick="location.href='tentang.php'">Tentang Kami</button>
          <button class="footer-link">Kontak</button>
          <button class="footer-link" onclick="location.href='login.php'">Masuk</button>
          <button class="footer-link" onclick="location.href='signup.php'">Daftar</button>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span class="footer-copy">Museum Kota Samarinda · Dinas Kebudayaan Kota Samarinda</span>
      <span class="footer-copy">Dirancang untuk menjaga ingatan kota</span>
    </div>
  </div>
</footer>
<script src="assets/js/tentang.js"></script>
<script src="assets/js/scroll-fade-in.js"></script>
<script>
(function(){
'use strict';

/* ──────────────────────────────────────────
   1. STACKED SWIPEABLE CARDS
────────────────────────────────────────── */
const CARDS = [
  { counter:'01 / 04', year:'2003',  title:'Asal-Usul Museum',
    body:'Museum Kota Samarinda didirikan atas prakarsa Pemerintah Kota Samarinda bersama Dinas Kebudayaan Kalimantan Timur, sebagai upaya pelestarian dan dokumentasi kekayaan sejarah serta budaya kota yang telah berusia lebih dari tiga abad.' },
  { counter:'02 / 04', year:'1920s', title:'Bangunan Heritage',
    body:'Berlokasi di Jalan Bhayangkara No. 1, museum ini menempati bangunan heritage yang sebelumnya merupakan kantor pemerintahan era kolonial — salah satu artefak arsitektur tertua yang masih berdiri di pusat kota Samarinda.' },
  { counter:'03 / 04', year:'1.247', title:'Koleksi yang Kaya',
    body:'Sejak pembukaannya, museum telah mengumpulkan lebih dari seribu artefak: dari senjata tradisional suku Dayak, naskah kuno, pakaian adat Kesultanan Kutai, hingga dokumentasi fotografis era kolonial dan masa kemerdekaan.' },
  { counter:'04 / 04', year:'2018',  title:'Renovasi & Modernisasi',
    body:'Pada tahun 2018, museum menjalani renovasi besar senilai Rp 12,5 miliar yang menghadirkan pencahayaan museum-grade, katalog digital interaktif, dan ruang edukasi modern tanpa mengorbankan karakter bangunan aslinya.' }
];

function dots(active){
  return CARDS.map((_,i)=>`<span class="s-card-dot${i===active?' active':''}"></span>`).join('');
}

function buildStack(){
  const el = document.getElementById('card-stack');
  if(!el) return;
  CARDS.slice().reverse().forEach((d,ri)=>{
    const si = CARDS.length - ri;
    const c  = document.createElement('div');
    c.className = 's-card';
    c.style.setProperty('--i', si);
    c.innerHTML = `
      <div class="s-card-meta">
        <span class="s-card-counter">${d.counter}</span>
        <span class="s-card-dots">${dots(CARDS.length-si)}</span>
      </div>
      <div class="s-card-title">${d.title}</div>
      <div class="s-card-body">${d.body}</div>
      <div class="s-card-year">${d.year}</div>`;
    el.appendChild(c);
  });
  attachSwipe(el);
}

function reindex(el){
  [...el.querySelectorAll('.s-card')].forEach((c,i)=>{
    const si = el.querySelectorAll('.s-card').length - i;
    c.style.setProperty('--i', si);
    c.style.setProperty('--swipe-x','0px');
    c.style.setProperty('--swipe-rotate','0deg');
    c.style.opacity='1';
  });
}
function top(el){ const a=[...el.querySelectorAll('.s-card')]; return a[a.length-1]; }

function attachSwipe(el){
  let down=false,sx=0,cx=0,raf=null;
  const THR=80;
  const drag=dx=>{
    const c=top(el); if(!c) return;
    c.style.setProperty('--swipe-x',`${dx}px`);
    c.style.setProperty('--swipe-rotate',`${(dx/440)*14}deg`);
    c.classList.toggle('drag-left', dx<-20);
    c.classList.toggle('drag-right',dx> 20);
  };
  const commit=dir=>{
    const c=top(el); if(!c) return;
    c.classList.add('is-leaving');
    c.style.setProperty('--swipe-x',`${dir*window.innerWidth*1.3}px`);
    c.style.setProperty('--swipe-rotate',`${dir*32}deg`);
    setTimeout(()=>{
      el.insertBefore(c,el.firstChild);
      c.classList.remove('is-leaving','is-dragging','drag-left','drag-right');
      reindex(el);
    },430);
  };
  const cancel=()=>{
    const c=top(el); if(!c) return;
    c.classList.remove('is-dragging','drag-left','drag-right');
    c.classList.add('is-returning');
    c.style.setProperty('--swipe-x','0px');
    c.style.setProperty('--swipe-rotate','0deg');
    setTimeout(()=>c.classList.remove('is-returning'),350);
  };
  el.addEventListener('pointerdown',e=>{
    if(e.button!==0&&e.pointerType==='mouse') return;
    down=true; sx=cx=e.clientX;
    top(el)?.classList.add('is-dragging');
    el.setPointerCapture(e.pointerId);
  });
  el.addEventListener('pointermove',e=>{
    if(!down) return; cx=e.clientX;
    if(raf) cancelAnimationFrame(raf);
    raf=requestAnimationFrame(()=>drag(cx-sx));
  });
  const end=()=>{ if(!down) return; down=false; Math.abs(cx-sx)>=THR?commit((cx-sx)>0?1:-1):cancel(); };
  el.addEventListener('pointerup',end);
  el.addEventListener('pointercancel',end);
  el.addEventListener('keydown',e=>{
    if(e.key==='ArrowRight'||e.key==='ArrowDown') commit(1);
    if(e.key==='ArrowLeft' ||e.key==='ArrowUp')   commit(-1);
  });
}

/* ──────────────────────────────────────────
   2. SLIDER TIMELINE (sohrabzia PwPNpad)
────────────────────────────────────────── */
const TL = [
  { year:'2003', title:'Pendirian Museum',
    desc:'Museum Kota Samarinda resmi dibuka oleh Walikota Samarinda pada 17 Agustus 2003. Koleksi awal terdiri dari 287 artefak yang disumbangkan oleh warga dan instansi pemerintah.',
    icon:'★', era:'tw-era-founding' },
  { year:'2007', title:'Perluasan Koleksi Etnografi',
    desc:'Kerja sama dengan Lembaga Adat Dayak menghadirkan lebih dari 180 artefak baru, termasuk koleksi mandau, pakaian upacara, dan alat musik tradisional Kalimantan.',
    icon:'☆', era:'tw-era-growth' },
  { year:'2012', title:'Program Edukasi Pertama',
    desc:'Peluncuran program kunjungan sekolah terstruktur yang kini menjadi flagship museum, menjangkau lebih dari 15.000 pelajar per tahun di seluruh Kalimantan Timur.',
    icon:'✰', era:'tw-era-education' },
  { year:'2018', title:'Renovasi & Modernisasi',
    desc:'Renovasi besar senilai Rp 12,5 miliar menghadirkan pencahayaan museum-grade, sistem HVAC modern, ruang edukasi interaktif, dan tampilan baru yang menghormati bangunan heritage.',
    icon:'✮', era:'tw-era-modern' },
  { year:'2021', title:'Katalog Digital Diluncurkan',
    desc:'Peluncuran katalog digital memungkinkan publik mengakses dokumentasi koleksi secara online. Lebih dari 900 artefak terdigitalisasi dengan foto resolusi tinggi dan metadata lengkap.',
    icon:'✪', era:'tw-era-digital' },
  { year:'2024', title:'MoU Universitas Mulawarman',
    desc:'Penandatanganan MoU membuka akses penelitian kolaboratif dengan Universitas Mulawarman, memperkuat peran museum sebagai pusat riset sejarah dan budaya Kalimantan Timur.',
    icon:'⛦', era:'tw-era-future' }
];

function initTimeline(){
  const widget  = document.getElementById('timelineWidget');
  const content = document.getElementById('tw-content');
  const iconEl  = document.getElementById('tw-icon');
  const yearEl  = document.getElementById('tw-year');
  const titleEl = document.getElementById('tw-title');
  const descEl  = document.getElementById('tw-desc');
  const prog    = document.getElementById('tw-progress');
  const track   = document.getElementById('tw-track');
  const slider  = document.getElementById('tw-slider');
  const labelsC = document.getElementById('tw-labels');
  if(!widget||!slider) return;

  slider.max = TL.length - 1;
  let cur=0, auto, utimer;
  const ticks=[], labels=[];

  // Build ticks + labels
  TL.forEach((d,i)=>{
    const t=document.createElement('div');
    t.className='tw-tick';
    t.style.left=`calc(${(i/(TL.length-1))*100}%)`;
    track.appendChild(t); ticks.push(t);

    const s=document.createElement('span');
    s.className='tw-label';
    s.textContent=d.year;
    s.style.left=`${(i/(TL.length-1))*100}%`;
    s.addEventListener('click',()=>jump(i));
    labelsC.appendChild(s); labels.push(s);
  });

  // Activate first tick/label immediately
  ticks[0]?.classList.add('active');
  labels[0]?.classList.add('active');

  const els = [iconEl, yearEl, titleEl, descEl];

  function updateUI(idx){
    if(idx===cur) return;

    // Fade out current
    content.classList.remove('tw-fade-in');
    els.forEach(e=>{ e.classList.remove('tw-fade-in'); e.classList.add('tw-fade-out'); });

    ticks.forEach((t,i)=>t.classList.toggle('active',i===idx));
    labels.forEach((l,i)=>l.classList.toggle('active',i===idx));

    // Wait for fade-out to finish before swapping content
    content.addEventListener('animationend', function h(){
      content.removeEventListener('animationend',h);
      const d=TL[idx];
      iconEl.textContent  = d.icon;
      yearEl.textContent  = d.year;
      titleEl.textContent = d.title;
      descEl.textContent  = d.desc;

      TL.forEach(x=>widget.classList.remove(x.era));
      widget.classList.add(d.era);
      prog.style.width=`${(idx/(TL.length-1))*100}%`;

      els.forEach(e=>{ e.classList.remove('tw-fade-out'); e.classList.add('tw-fade-in'); });
      cur=idx;
    }, {once:true});
  }

  function jump(idx){ slider.value=idx; updateUI(idx); }

  slider.addEventListener('input',()=>updateUI(parseInt(slider.value)));

  function startAuto(){ auto=setInterval(()=>{ jump((cur+1)%TL.length); }, 3800); }
  function stopAuto() { clearInterval(auto); }

  slider.addEventListener('mousedown', ()=>stopAuto());
  slider.addEventListener('touchstart',()=>stopAuto(),{passive:true});
  const restart=()=>{ clearTimeout(utimer); utimer=setTimeout(startAuto,5000); };
  slider.addEventListener('mouseup', restart);
  slider.addEventListener('touchend',restart);

  setTimeout(startAuto, 2200);
}

/* ──────────────────────────────────────────
   3. TEAM CARD SCROLL REVEAL
────────────────────────────────────────── */
function initReveal(sel,cls){
  const els=document.querySelectorAll(sel);
  if(!els.length) return;
  const reveal=el=>el.classList.add(cls);

  if(!('IntersectionObserver' in window)){
    els.forEach(reveal);
    return;
  }

  const obs=new IntersectionObserver(entries=>{
    entries.forEach(entry=>{
      if(!entry.isIntersecting) return;
      reveal(entry.target);
      obs.unobserve(entry.target);
    });
  },{threshold:0.12,rootMargin:'0px 0px -20px 0px'});

  els.forEach(el=>{
    const rect=el.getBoundingClientRect();
    const vh=window.innerHeight||document.documentElement.clientHeight;
    const alreadyVisible=rect.top < vh-20 && rect.bottom > 0;
    if(alreadyVisible){
      reveal(el);
      return;
    }
    obs.observe(el);
  });
}

/* ── INIT ── */
function initPage(){
  buildStack();
  initTimeline();
  initReveal('.team-card','tc-visible');
}

if(document.readyState==='loading'){
  document.addEventListener('DOMContentLoaded',initPage,{once:true});
}else{
  initPage();
}

}());
</script>
</body>
</html>