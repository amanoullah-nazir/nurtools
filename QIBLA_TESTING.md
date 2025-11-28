# Qibla Compass Testing Guide

## How the Compass Works

The Qibla compass uses your device's magnetometer and GPS to show the direction to the Kaaba in Makkah.

### Visual Elements

1. **Rotating Compass Ring** (with N, S, E, W)
   - Rotates based on your device's heading
   - North always points to magnetic north

2. **Green Arrow**
   - Always points toward Makkah (Qibla direction)
   - Contains a Kaaba icon at its base
   - Fixed relative to true north

3. **Red Indicator** (top of compass)
   - Shows where your device is currently pointing
   - When the green arrow aligns with the red indicator, you're facing Qibla

4. **Bearing Displays**
   - **Qibla:** Direction to Makkah from your location (0-360°)
   - **Heading:** Current direction your device is pointing

## Testing Instructions

### Desktop Testing (Limited)
Desktop browsers don't have magnetometers, so the compass won't rotate. You can only see:
- Your location coordinates
- Distance to Makkah
- Qibla bearing (direction)
- Static compass display

### Mobile Testing (Full Functionality)

#### Prerequisites
- Smartphone with magnetometer (compass sensor)
- Location services enabled
- Modern mobile browser (Chrome, Safari)
- HTTPS connection (or localhost for testing)

#### Step-by-Step Test

1. **Open the app**
   ```
   http://localhost:8000/qibla
   ```

2. **Grant permissions**
   - Allow location access when prompted
   - On iOS 13+: Tap button to allow motion sensors

3. **Calibrate compass**
   - Hold device flat (parallel to ground)
   - Move device in a figure-8 motion
   - This calibrates the magnetometer

4. **Use the compass**
   - Hold device flat in front of you
   - Rotate your body (not just the device)
   - Watch the compass ring rotate
   - Face the direction where green arrow points up (aligns with red indicator)
   - That's the Qibla direction!

### iOS Specific (Safari)

**First Time Setup:**
1. Visit the page
2. You'll see a "Calibrating" message
3. Tap anywhere to request motion sensor permission
4. Select "Allow" in the popup
5. Compass will start working

**Compass Not Working?**
- Go to Settings → Safari → Motion & Orientation Access → On
- Reload the page

### Android Specific (Chrome)

**Setup:**
- Motion sensors work automatically
- Just allow location access
- No additional permissions needed

**Tips:**
- Works best outdoors or near windows
- Avoid areas with magnetic interference (electronics, metal structures)
- GPS accuracy improves over time

## Expected Behavior

### On Page Load
1. "Getting your location..." appears
2. Location acquired (5-15 seconds)
3. Compass becomes active
4. Background and needle start rotating with device

### During Use
- Compass ring rotates smoothly as you turn
- Green arrow stays pointed toward Makkah
- Bearings update in real-time
- No lag or stuttering (if device is capable)

## Common Issues

### "Location permission denied"
**Fix:** 
- Check browser settings
- Enable location in device settings
- Reload page and allow when prompted

### "Compass permission denied" (iOS)
**Fix:**
- Safari → Settings → Motion & Orientation Access
- Enable for the website
- Reload page

### Compass not rotating
**Possible causes:**
- Device doesn't have magnetometer
- Testing on desktop (not supported)
- Magnetic interference nearby
- Sensor needs calibration

**Fix:**
- Calibrate by moving device in figure-8
- Move away from metal/electronics
- Restart browser
- Test on different device

### Inaccurate direction
**Causes:**
- Magnetic interference
- Poor GPS signal
- Uncalibrated compass
- Device held at angle

**Fix:**
- Move outdoors
- Hold device flat
- Calibrate compass
- Check near window if indoors

### GPS takes too long
**Normal:** 5-30 seconds for first fix
**If longer:**
- Move outdoors or near window
- Enable high accuracy mode
- Check internet connection
- Restart location services

## Testing Checklist

### Functionality
- [ ] Page loads without errors
- [ ] Location permission prompt appears
- [ ] User location coordinates display
- [ ] Distance to Makkah calculates
- [ ] Qibla bearing calculates (from API)
- [ ] Compass ring rotates with device
- [ ] Green arrow points to fixed direction
- [ ] Heading updates in real-time
- [ ] Smooth animations (no lag)

### iOS Safari
- [ ] Motion permission prompt works
- [ ] webkitCompassHeading detected
- [ ] Compass rotates smoothly
- [ ] No console errors

### Android Chrome
- [ ] Orientation event registered
- [ ] Alpha value used for heading
- [ ] Compass accurate to ±5 degrees
- [ ] Works without permission prompt

### Error Handling
- [ ] Location denied shows helpful message
- [ ] Timeout handled gracefully
- [ ] Retry button works
- [ ] Troubleshooting tips display
- [ ] Network errors caught

### PWA Features
- [ ] Works offline after first load
- [ ] Service worker caches compass
- [ ] Installable as app
- [ ] Standalone mode displays correctly

## Performance Metrics

**Target:**
- Location acquisition: < 15 seconds
- Compass rotation: 60 FPS
- Bearing calculation: < 100ms
- Orientation update: < 50ms

**Acceptable:**
- Location: < 30 seconds
- Rotation: 30+ FPS
- Calculation: < 500ms
- Update: < 100ms

## Production Deployment Notes

### Requirements
- Must be served over HTTPS
- Valid SSL certificate required
- Location API requires secure context
- Motion sensors need HTTPS (except localhost)

### Recommended
- CDN for faster loading
- Compress assets
- Enable GZIP/Brotli
- Cache headers properly set

### Testing on Production
1. Deploy to HTTPS server
2. Test on real devices (iOS + Android)
3. Verify in different locations
4. Check in various buildings
5. Test outdoors for best accuracy
6. Validate cross-browser compatibility

## Accuracy Notes

- **Compass Accuracy:** ±5-10 degrees typical
- **GPS Accuracy:** Depends on signal quality
- **Qibla Calculation:** Mathematically precise
- **Real-world factors:** Magnetic declination, interference

The compass provides a good approximation. For precise prayer direction, consider local mosque guidance or traditional methods.

## Future Enhancements

Potential improvements:
- [ ] Add magnetic declination correction
- [ ] Show compass accuracy indicator
- [ ] Add haptic feedback when aligned
- [ ] Show qibla alignment percentage
- [ ] Add AR (augmented reality) view
- [ ] Save favorite locations
- [ ] Add nearby mosque locations
- [ ] Include prayer time integration
