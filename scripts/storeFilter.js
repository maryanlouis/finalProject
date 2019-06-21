angular
	.module('ngStore')
	.filter('storeFilter', function() {
		return function(listings, priceInfo) {
			var filtered = [];

			var min = priceInfo.min;
			var max = priceInfo.max;

			angular.forEach(listings, function(listing) {
				if (listing.discount >= min && listing.discount <= max) {
					filtered.push(listing);
				}
			});

			return filtered;
		}
	});