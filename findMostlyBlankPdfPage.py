import os
import glob
from pdf2image import convert_from_path
from PIL import Image

# 1. Define your target directory
target_dir = './output'

# 2. Find the most recently created PDF
# We use st_ctime for creation time (st_mtime for modification)
list_of_pdfs = glob.glob(os.path.join(target_dir, "*.pdf"))

if not list_of_pdfs:
    print("No PDF files found in the directory.")
else:
    # Sort files by creation time and pick the last one
    latest_pdf = max(list_of_pdfs, key=os.path.getctime)
    print(f"Analyzing latest file: {latest_pdf}")

    # 3. Analyze for blank pages
    # Render at low DPI (100 is enough for blank detection) to save memory
    pages = convert_from_path(latest_pdf, dpi=100)

    for i, page in enumerate(pages):
        # Convert to black and white (1-bit pixels)
        bw_page = page.convert('1')
        histogram = bw_page.histogram()
        
        # In a 1-bit histogram: index 0 is Black, index 1 is White
        black_pixels = histogram[0]
        
        # Threshold: If black pixels are < 0.01% of total pixels, it's "mostly blank"
        total_pixels = bw_page.size[0] * bw_page.size[1]
        if (black_pixels / total_pixels) < 0.0001:
            print(f"Page {i+1} is mostly blank (Black pixel count: {black_pixels})")
