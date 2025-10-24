import os
import glob
import shutil
from datetime import datetime

def rename_latest_pdf(directory, new_name):
    """
    Renames the most recent PDF in a directory to 'new_name.pdf'.
    If 'new_name.pdf' already exists, that file is renamed to 'new_name_OLD_<timestamp>.pdf'.
    If the rename fails (e.g., because the file is open), a copy is created instead.
    """
    if not os.path.isdir(directory):
        print(f"Error: Directory '{directory}' does not exist.")
        return

    pdf_files = glob.glob(os.path.join(directory, "*.pdf"))
    if not pdf_files:
        print("No PDF files found in the directory.")
        return

    latest_pdf = max(pdf_files, key=os.path.getmtime)
    new_path = os.path.join(directory, f"{new_name}.pdf")

    # If a file with the target name already exists, rename it with timestamp
    if os.path.exists(new_path):
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        old_path_newname = os.path.join(directory, f"{new_name}_OLD_{timestamp}.pdf")
        try:
            os.rename(new_path, old_path_newname)
            print(f"Existing file renamed to: {old_path_newname}")
        except PermissionError:
            # If the file is open, create a backup copy instead
            copy_name = os.path.join(directory, f"{new_name}.pdf") ; #_OLD_{timestamp}_COPY.pdf")
            shutil.copy2(new_path, copy_name)
            print(f"Existing file is open — copied to: {copy_name}")

    # Try to rename the most recent file
    try:
        os.rename(latest_pdf, new_path)
        print(f"Renamed most recent PDF:\n  {latest_pdf}\n→ {new_path}")
    except PermissionError:
        # If rename fails (e.g., file open), save a copy instead
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        copy_name = os.path.join(directory, f"{new_name}.pdf") ; #_OLD_{timestamp}_COPY.pdf")
        shutil.copy2(latest_pdf, copy_name)
        print(f"Could not rename (file may be open). Copied instead:\n  {copy_name}")




# Example usage:
# Change these to your actual folder path and desired filename.
if __name__ == "__main__":
    folder = r"C:\Users\akend\OneDrive\Documents\GitHub\recalendarjsAK\output"
    new_filename = "Journal25-Jul-Dec"  # no .pdf extension needed
    rename_latest_pdf(folder, new_filename)
    folder =r"D:\AKProgramming\GitHub\recalendar\output"
    rename_latest_pdf(folder, new_filename)
