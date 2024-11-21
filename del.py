import os
from PIL import Image
import imagehash
from tkinter import Tk, filedialog

def select_images():
    """Open a file dialog to select multiple image files."""
    root = Tk()
    root.withdraw()  # Hide the Tkinter GUI window
    file_paths = filedialog.askopenfilenames(
        title="Select Images to Check for Similarity",
        filetypes=[("Image Files", "*.jpg *.jpeg *.png *.bmp *.gif")]
    )
    return file_paths

def find_and_delete_similar_images(file_paths):
    """Identify and delete all but one of each group of similar images."""
    hashes = {}

    for file_path in file_paths:
        try:
            # Compute the hash for the image
            img = Image.open(file_path)
            img_hash = imagehash.average_hash(img)

            # Check for similar images and retain only one
            if img_hash in hashes:
                print(f"Deleting duplicate: {file_path} (similar to {hashes[img_hash]})")
                os.remove(file_path)
            else:
                hashes[img_hash] = file_path

        except Exception as e:
            print(f"Error processing {file_path}: {e}")

if __name__ == "__main__":
    print("Select the images to check for similarity.")
    file_paths = select_images()

    if len(file_paths) < 2:
        print("Please select at least two images.")
    else:
        print("Finding and deleting similar images...")
        find_and_delete_similar_images(file_paths)

print("Process completed.")