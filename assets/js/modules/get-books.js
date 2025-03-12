/*
 * Script for get books
 */


export const getBooks = () => {
	fetch(ajax_object.ajax_url + '?action=get_books')
	.then(response => response.json())
	.then(data => {
		console.log(data); // Handle the JSON response containing the books
		// You can update the DOM or perform other actions with the data here
	})
	.catch(error => console.error('Error fetching books:', error));
};
