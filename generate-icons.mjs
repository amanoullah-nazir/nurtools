import sharp from 'sharp';
import { readFileSync } from 'fs';

// Convert SVG to PNG for PWA icons
const convertIcon = async (inputPath, outputPath, size) => {
    try {
        const svgBuffer = readFileSync(inputPath);
        await sharp(svgBuffer)
            .resize(size, size)
            .png()
            .toFile(outputPath);
        console.log(`✓ Created ${outputPath}`);
    } catch (error) {
        console.error(`Error creating ${outputPath}:`, error);
    }
};

// Generate icons
(async () => {
    await convertIcon('public/icon-192x192.svg', 'public/icon-192x192.png', 192);
    await convertIcon('public/icon-512x512.svg', 'public/icon-512x512.png', 512);
    console.log('PWA icons generated successfully!');
})();
