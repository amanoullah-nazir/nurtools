import sharp from 'sharp';
import { readFileSync } from 'fs';

// Generate favicon.ico from SVG
const generateFavicon = async () => {
    try {
        const svgBuffer = readFileSync('public/icon-192x192.svg');
        
        // Generate 32x32 PNG for favicon
        await sharp(svgBuffer)
            .resize(32, 32)
            .png()
            .toFile('public/favicon-32.png');
        
        console.log('✓ Created public/favicon-32.png');
        console.log('Note: Rename favicon-32.png to favicon.ico or use an online converter');
    } catch (error) {
        console.error('Error creating favicon:', error);
    }
};

generateFavicon();
