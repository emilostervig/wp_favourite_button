(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	let WpFavouritePlugin = function(){
		const self = this;

		self.token = favourite_data.token
		self.APIToken = favourite_data.api_token
		self.add_route = favourite_data.add_route;
		self.init = function(){

			self.addClickEvents();
			document.addEventListener('ajaxComplete', self.addClickEvents);
		}

		self.addClickEvents = function(){

			let triggers = document.querySelectorAll('.favourite-btn[data-post-id]');
			for (var i = 0; i < triggers.length; i++) {
				triggers[i].removeEventListener('click', self.onFavouriteClick);
				triggers[i].addEventListener('click', self.onFavouriteClick);
			}

		}


		self.onFavouriteClick = function(evt){
			evt.preventDefault();
			let target = this;
			if(target.getAttribute('disabled') != null){
				return false;
			}
			let postId = target.getAttribute('data-post-id');
			let isActive = target.classList.contains('active');
			let oldClasses = target.getAttribute('class');
			// toggle class before xhr for perceived speed
			if(isActive){
				target.classList.remove('active');
			} else{
				target.classList.add('active');
			}
			target.setAttribute('disabled', true);
			let dispatch = self.favouriteFetch(postId)
				.then((response) => {
					if('action' in response && response.action == 'add' && response.result == true){
						target.classList.add('active');
					} else if('action' in response && response.action == 'remove' && response.result == true){
						target.classList.remove('active');
					} else{
						// something went wrong. Should revert class.
						target.setAttribute('class', oldClasses);
					}
				})
				.then(() => {
					target.removeAttribute('disabled');
				})
		}
		self.favouriteFetch = function(postId){
			let obj = {
				method: 'POST',
				headers: {
					'X-WP-Nonce': self.APIToken
				}
			}
			let route = self.add_route + '/'+postId+'?token='+self.token;
			return fetch(route, obj)
				.then((response) => {
					return response.json();
				})
		}

		self.init();
	}
	document.addEventListener('DOMContentLoaded', function(){
		window.WpFavouritePlugin = new WpFavouritePlugin();
	})

})( jQuery );
