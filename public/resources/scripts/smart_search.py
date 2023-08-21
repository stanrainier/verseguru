import pandas as pd
from sentence_transformers import SentenceTransformer, util
import os
import joblib  # For caching embeddings
import sys

# Step 1: Load the SBERT model
model = SentenceTransformer('distilbert-base-nli-stsb-mean-tokens')

# Step 2: Load the Bible verses from a CSV or any other data source
def load_bible_verses(csv_file):
    df = pd.read_csv(csv_file)
    verses = df['bible_verse'].tolist()
    return verses

# Step 3: Generate embeddings and index (with caching)
def generate_verse_embeddings(verses):
    embeddings_cache_file = "C:\\Users\\stanr\\laravel\\VerseGuru\\public\\resources\\scripts\\embeddings_cache.pkl"
    if os.path.exists(embeddings_cache_file):
        # Load embeddings from cache if available
        verse_embeddings = joblib.load(embeddings_cache_file)
        return verse_embeddings
    else:
        verse_embeddings = model.encode(verses)
        joblib.dump(verse_embeddings, embeddings_cache_file)  # Save embeddings to cache
        return verse_embeddings

# Step 4: Search function
def search_bible_verses(query, verses, verse_embeddings, top_k=5):
    # Convert the query to a vector using SBERT
    query_vector = model.encode([query])[0]

    # Perform Approximate Nearest Neighbor search
    results = util.semantic_search(query_vector, verse_embeddings, top_k=top_k)

    # Get the verse IDs and similarity scores from the results
    verse_ids = [result['corpus_id'] for result in results[0]]
    similarity_scores = [result['score'] for result in results[0]]

    return verse_ids, similarity_scores

# Example usage
if __name__ == "__main__":
    # Assuming you have a CSV dataset with a column named 'Verse' containing Bible verses
    csv_file = "public\\resources\\datasets\kjv.csv"
    verses = load_bible_verses(csv_file)
    # 
    # Generate verse embeddings
    verse_embeddings = generate_verse_embeddings(verses)
    
    # while True:
        # Get user input
        # user_query = " ".join(sys.argv[1:])
        
        # user_query = sys.argv[1]
    user_query = " ".join(sys.argv[1:])
    
    # if user_query.lower() == 'exit':
    #     # break
    
    # if not user_query:
    #     print("Please enter a search query.")
    #     # continue

    # Perform the search
    top_k = 10
    verse_ids, similarity_scores = search_bible_verses(user_query, verses, verse_embeddings, top_k=top_k)

    # Print the search results
    print(f"Search Results for query: '{user_query}':")
    for i, verse_id in enumerate(verse_ids):
        verse_text = verses[verse_id]  # Retrieve the actual Bible verse from the list of verses
        print(f"{i+1}. Similarity Score: {similarity_scores[i]}")
        print(verse_text)
        print()

        # C:\Users\ACER\AppData\Local\Programs\Python\Python311\python.exe C:\Users\ACER\Desktop\rawn\ronron_school\capstone\Laravel\VerseGuru\public\resources\scripts\bibleverse_guru.py "liquor"
