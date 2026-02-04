import os
import glob
import shutil
from datetime import datetime
from pathlib import Path


def rename_and_archive_latest_pdf(source_dir: Path | str, desired_name: str):
    """
    1. Finds the most recent .pdf in source_dir
    2. Renames it in place to <desired_name>.pdf  (in the source_dir)
    3. Copies any existing <desired_name>.pdf → versions/ folder first
       (renaming it to <desired_name>_<YYYY-MMM-DD>.pdf or with counter)
    4. Creates versions/ folder if it doesn't exist

    Behavior when file is locked/open:
    - Tries rename → falls back to copy with timestamp if fails
    """
    source_dir = Path(source_dir).resolve()
    versions_dir = source_dir / "versions"

    print(f"Working in: {source_dir}")

    # 1. Create versions folder if missing
    if not versions_dir.is_dir():
        try:
            versions_dir.mkdir(parents=True, exist_ok=True)
            print(f"Created folder: {versions_dir}")
        except Exception as e:
            print(f"Failed to create versions folder: {e}")
            return

    # 2. Find the latest PDF
    pdf_files = list(source_dir.glob("*.pdf"))
    if not pdf_files:
        print("No .pdf files found in the directory.")
        return

    latest_pdf = max(pdf_files, key=lambda p: p.stat().st_mtime)
    print(f"Latest PDF: {latest_pdf.name}"
          f"  (modified {datetime.fromtimestamp(latest_pdf.stat().st_mtime):%Y-%m-%d %H:%M})")

    # 3. Target name in the main folder
    target_path = source_dir / f"{desired_name}.pdf"

    # 4. If the desired name already exists → archive the old one to versions/
    if target_path.exists() and target_path != latest_pdf:
        date_str = datetime.now().strftime("%Y-%b-%d")  # → 2025-Oct-17
        stem = desired_name
        ext = ".pdf"
        archived_name = f"{stem}_{date_str}{ext}"
        archived_path = versions_dir / archived_name

        # Avoid name collision (rare, but safe)
        counter = 1
        while archived_path.exists():
            archived_name = f"{stem}_{date_str}_{counter:02d}{ext}"
            archived_path = versions_dir / archived_name
            counter += 1

        try:
            shutil.move(target_path, archived_path)
            print(f"  Archived old file → versions/{archived_path.name}")
        except Exception as e:
            print(f"  Could not move old file to versions/: {e}")
            # Continue anyway — we'll still try to rename/copy the new one

    # 5. Now try to rename the latest file to the desired name
    try:
        os.rename(latest_pdf, target_path)
        print(f"Renamed in place:\n  {latest_pdf.name}\n→ {target_path.name}")
    except PermissionError:
        print("  PermissionError: file may be open/locked. Falling back to copy...")
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        fallback_name = f"{desired_name}_COPY_{timestamp}.pdf"
        fallback_path = source_dir / fallback_name

        try:
            shutil.copy2(latest_pdf, fallback_path)
            print(f"  Created fallback copy: {fallback_name}")
            # We still have the old file archived if it existed
        except Exception as e:
            print(f"  Copy also failed: {e}")
            return
    except Exception as e:
        print(f"  Rename failed: {e}")
        return

    print("Done.")


# ────────────────────────────────────────────────
if __name__ == "__main__":
    # Example usage
    output_folder = Path.cwd() / "output"

    # Choose your journal name
    journal_name = "Journal26-Jan-Jun"
    # journal_name = "Journal25-Jul-Dec"

    rename_and_archive_latest_pdf(output_folder, journal_name)