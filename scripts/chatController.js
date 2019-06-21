angular
	.module('ngChat')
	.controller('chatController', function($scope, chatFactory) {
		//$scope.hello = 'Hello world!';
		//$scope.cribs = cribsFactory.getCribs();
		$scope.comments;

		$scope.newListing = {};
		$scope.addComment = function(newListing) {
			//newListing.image = 'default-product';
			$scope.comments.push(newListing);
			$scope.newListing = {};
		}

		$scope.editComment = function (comment) {
			$scope.editListing = true;
			$scope.existingListing = comment;
		}

		$scope.saveCommentEdit = function() {
			$scope.existingListing = {};
			$scope.editListing = false;
		}

		$scope.deleteComment = function (listing) {
			var index = $scope.comments.indexOf(listing);
			$scope.comments.splice(index, 1);
			$scope.existingListing = {};
			$scope.editListing = false;
		}
		
		chatFactory.getChat().success(function(data) {
			$scope.comments = data;
		}).error(function(error) {
			console.log(error);
		});

		/*$scope.sayHello = function () {
			console.log("Hello!");
		}*/
	});