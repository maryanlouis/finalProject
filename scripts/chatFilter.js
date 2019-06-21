angular
	.module('ngChat')
	.filter('chatFilter', function() {
		return function(listings, priceInfo) {
			var filtered = [];

			angular.forEach(listings, function(listing) {
				if (listing.price >= min && listing.price <= max) {
					filtered.push(listing);
				}
			});

			return filtered;
		}
	});