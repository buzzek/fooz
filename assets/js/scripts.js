
import { getBooks } from "./modules/get-books";

document.addEventListener("DOMContentLoaded", () => {
	/*
	 *
	 * Add exported functions here, will be loaded after dom
	 *
	 */

	getBooks();


	window.addEventListener("scroll", () => {
		/*
		 *
		 * Add exported functions here, will be loaded on scroll
		 *
		 */

	});

	window.addEventListener("resize", () => {
		/*
		 *
		 * Add exported functions here, will be loaded on resize
		 *
		 */
	});
});
