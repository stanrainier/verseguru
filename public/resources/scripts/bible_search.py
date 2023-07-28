import requests
import sys
from transformers import ElectraTokenizer, ElectraForQuestionAnswering
import torch

def search_bible_api(query, limit=10):
    bible_api_url = "https://api.scripture.api.bible/v1/bibles/de4e12af7f28f599-01/search"
    api_key = "9b24277b494bee48f28523da7b96a025"

    params = {
        "query": query,
        "limit": limit,
    }

    headers = {
        "api-key": api_key,
    }

    try:
        response = requests.get(bible_api_url, params=params, headers=headers)
        response.raise_for_status()

        data = response.json()
        search_results = []

        if "data" in data and "verses" in data["data"]:
            for verse in data["data"]["verses"]:
                if "reference" in verse and "text" in verse:
                    id = verse["reference"]
                    text = verse["text"]
                    search_results.append({"reference": id, "text": text})

        return search_results

    except requests.exceptions.RequestException as e:
        print(f"Error making API request: {e}")
        return None

def get_relevant_verses(user_query, verses, relevance_threshold=0.1):
    if not verses:
        return None

    tokenizer = ElectraTokenizer.from_pretrained('google/electra-large-discriminator')
    model = ElectraForQuestionAnswering.from_pretrained('google/electra-large-discriminator')

    relevant_verses = []
    max_start_score = float("-inf")
    selected_verses = set()  # Store references of selected verses

    for verse in verses:
        verse_text = verse["text"]
        inputs = tokenizer.encode_plus(user_query, verse_text, return_tensors="pt", max_length=512, truncation=True)

        # Handle cases where the model input is insufficient
        if len(inputs["input_ids"][0]) == 1:
            continue

        start_scores = model(**inputs).start_logits

        # Use max method to get the maximum value and its corresponding index
        max_score, max_idx = start_scores.max(), start_scores.argmax()

        if max_score > max_start_score:
            max_start_score = max_score

        # Check if the verse reference is already included, and skip if it is
        if verse["reference"] in selected_verses:
            continue

        # Store all verses with a significant start score based on the threshold
        if max_score > relevance_threshold:
            relevant_verses.append({"verse": verse, "score": max_score.item()})
            selected_verses.add(verse["reference"])  # Add the reference to the set of selected verses

    # Sort relevant verses based on start score in descending order
    relevant_verses.sort(key=lambda x: x["score"], reverse=True)

    return relevant_verses

if __name__ == "__main__":
    user_query = " ".join(sys.argv[1:])


    # Search with different variations of the user's query
    query_variations = [user_query, f"{user_query}'s", f"{user_query.split()[0]} of {user_query.split()[1]}"]
    all_verses = []
    for query_variation in query_variations:
        verses = search_bible_api(query_variation, limit=10)
        if verses:
            all_verses.extend(verses)

    if all_verses:
        # Keyword-based searching using the NLP model
        relevant_verses = get_relevant_verses(user_query, all_verses)

        if relevant_verses:
            top_verses_limit = min(len(relevant_verses), 10)  # Get the top 10 or less relevant verses

            max_start_score = relevant_verses[0]["score"]  # Get the maximum start score from the relevant verses

            for result in relevant_verses[:top_verses_limit]:
                verse = result["verse"]
                start_score = result["score"]
                relevance_percentage = (start_score / max_start_score) * 100
                print(f"{verse['reference']}: {verse['text']} (Relevance: {relevance_percentage:.2f}%)")
        else:
            print(f"The phrase '{user_query}' does not appear in any Bible verse.")
    else:
        print(f"No results found for the phrase '{user_query}'.")
