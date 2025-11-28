# PWA Testing Guide

## Testing Locally

### Requirements
- Your app must be served over HTTPS or localhost
- Modern browser (Chrome 90+, Edge 90+, Safari 14+, Firefox 90+)

### Development Testing

1. **Start the development server:**
   ```bash
   php artisan serve
   ```

2. **Build assets:**
   ```bash
   npm run build
   ```

3. **Open in browser:**
   - Visit: `http://localhost:8000`
   - Open DevTools (F12)
   - Go to Application tab → Service Workers
   - Verify service worker is registered

### Testing PWA Features

#### 1. Service Worker Registration
- **Chrome DevTools:** Application → Service Workers
- Should show: "Status: activated and running"
- Console should show: "App ready to work offline"

#### 2. Manifest
- **Chrome DevTools:** Application → Manifest
- Verify:
  - Name: "Nurtools - Islamic Tools"
  - Theme Color: #059669
  - Icons: 192x192 and 512x512 visible
  - Display: standalone

#### 3. Offline Mode
- **Chrome DevTools:** Application → Service Workers → Offline
- Check the "Offline" checkbox
- Navigate to Qibla or Zakaat pages
- Pages should load from cache

#### 4. Install Prompt
- Desktop: Look for install icon (⊕) in address bar
- Mobile: Install prompt should appear at bottom
- Click "Install" to add to home screen/desktop

### Testing on Real Devices

#### Android (Chrome)
1. Deploy to HTTPS server or use ngrok for localhost
2. Open in Chrome mobile browser
3. Install prompt should appear
4. Tap "Add to Home Screen"
5. App opens in standalone mode without browser UI

#### iOS (Safari)
1. Deploy to HTTPS server
2. Open in Safari
3. Tap Share button → "Add to Home Screen"
4. App appears as icon on home screen
5. Opens in standalone mode

### Common Issues

**Service Worker not registering:**
- Clear browser cache and reload
- Check console for errors
- Ensure you're on localhost or HTTPS

**Install prompt not showing:**
- Some browsers don't show prompt immediately
- Check if already installed
- Clear "Add to Home Screen" data in browser settings

**Offline not working:**
- Check Service Worker status in DevTools
- Verify cached resources in Cache Storage
- Try hard refresh (Ctrl+Shift+R)

### Production Testing

1. **Deploy to HTTPS server**
2. **Test with Lighthouse:**
   - Chrome DevTools → Lighthouse
   - Run PWA audit
   - Should score 100/100 for PWA category

3. **Test install flow:**
   - Desktop and mobile browsers
   - Verify standalone display mode
   - Check offline functionality

### Debugging

**View Cached Resources:**
- DevTools → Application → Cache Storage
- Should see: workbox-precache and runtime caches

**Service Worker Logs:**
- DevTools → Console
- Filter by "service worker" or "workbox"

**Network Inspection:**
- DevTools → Network
- Look for "(from ServiceWorker)" in Size column
- Indicates resource served from cache

## Metrics to Verify

✅ Service worker registers successfully  
✅ Manifest loads without errors  
✅ Icons display correctly (192x192, 512x512)  
✅ App installable on desktop and mobile  
✅ Offline mode works for core features  
✅ Cache updates automatically  
✅ Install prompt appears and functions  
✅ Lighthouse PWA score: 90+  

## Browser Support

| Browser | Install | Offline | Notes |
|---------|---------|---------|-------|
| Chrome 90+ | ✅ | ✅ | Full support |
| Edge 90+ | ✅ | ✅ | Full support |
| Safari 14+ | ⚠️ | ✅ | Manual install only |
| Firefox 90+ | ⚠️ | ✅ | Limited install support |
| Mobile Chrome | ✅ | ✅ | Recommended |
| Mobile Safari | ⚠️ | ✅ | Add to Home Screen |

## Next Steps

- Deploy to production HTTPS server
- Test on multiple devices
- Monitor service worker errors
- Add push notification support (future)
- Implement background sync (future)
