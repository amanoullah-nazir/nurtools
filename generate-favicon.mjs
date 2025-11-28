import sharp from 'sharp';

// Favicon matching the Lucide Compass icon in menu bar
const generateFavicon = async () => {
    try {
        const svg = `
<svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
  <!-- Background circle -->
  <circle cx="16" cy="16" r="14" fill="#059669"/>
  
  <!-- Compass icon (Lucide style) -->
  <g stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <!-- Outer circle -->
    <circle cx="16" cy="16" r="8"/>
    <!-- North-South pointer -->
    <polygon points="16,10 14,16 16,14 18,16" fill="white" stroke="none"/>
    <polygon points="16,22 18,16 16,18 14,16" fill="white" stroke="none" opacity="0.7"/>
  </g>
</svg>
`;
        
        const svgBuffer = Buffer.from(svg);
        
        // Generate 32x32 PNG for favicon
        await sharp(svgBuffer)
            .resize(32, 32)
            .png()
            .toFile('public/favicon-32.png');
        
        console.log('✓ Created public/favicon-32.png');
        console.log('Note: Rename favicon-32.png to favicon.ico or use Copy-Item in PowerShell');
    } catch (error) {
        console.error('Error creating favicon:', error);
    }
};

generateFavicon();
