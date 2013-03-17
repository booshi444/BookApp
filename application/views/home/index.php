<!DOCTYPE html>
<html>
    <head>
    	<title>BookApp</title>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="css/bootstrap-responsive.min.css"/>
	</head>
	<body>
		<h3  id="name">
			<a href="/" />
			Shelfari  1.0
		</h3>
		<hr />
	    <ul class="header">
    		<a href="#/list" class="btn btn-primary">List My Books</a>
    		<a href="#/new" class="btn btn-primary">Add a New Book</a>
	    </ul>

	    <hr />

	    <div class="top">
			<div class="bookAppPanel"></div>
		</div>

		<script type="text/template" id="book-list-template">
			<table class="table stripped">
				<thead>
					<tr>
						<th>Book Name</th>
						<th>Author Name</th>
						<th>Have you read it?</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<% books.each(function(book){ %>
						<tr>
							<td><%= book.get('book_name') %></td>
							<td><%= book.get('author_name') %></td>
							<td><%= book.get('is_read') %></td>
							<td><a href="#/edit/<%= book.id %>" class="btn">Edit</a></td>
						</tr>
					<% }); %>
				</tbody>
			</table>
		</script>

		<script type="text/template" id="edit-book-template">
			<form class="edit-book-form">
				<legend><%= book ? 'Update this' : 'Add New' %> Book</legend>
				<label>Please tell me the name of the book:</label>
				<input type="text" name="book_name" value="<%= book ? book.get('book_name') : '' %>"/>
				<label>Please tell me the name of the Author:</label>
				<input type="text" name="author_name" value="<%= book ? book.get('author_name') : '' %>"/>
				<label>Have you read the book?</label>
				<input type="text" name="is_read" value="<%= book ? book.get('is_read') : '' %>"/>
				<hr />
				<button type="submit" class="btn"><%= book ? 'Update' : 'Add' %></button>
				<% if(book) { %>
					<button class="btn btn-danger delete">Delete</button>
					<input type="hidden" name="id" value="<%= book.id %>" />
				<% }; %>
			</form>
		</script>

		<div id="credits">
			Created by
			<br>
				Booshi
			</br>
			Powered using
			<a class="links" href="http://backbonejs.org/" target="_blank">Backbone.js</a>
			,
			<a class="links" href="http://laravel.com/" target="_blank">Laravel PHP</a>
			and
			<a class="links" href="http://twitter.github.com/bootstrap/" target="_blank">Bootstrap</a>
			
		</div>


		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.4.4/underscore-min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/backbone.js/0.9.10/backbone-min.js"></script>
		<script>

			$.fn.SerializeObject = function(){
				var o = {};
				var a = this.serializeArray();
				$.each(a, function(){
					if(o[this.name] != undefined){
						if(!o[this.name].push){
							o[this.name] = [o[this.name]];
						}
						o[this.name].push(this.value || '');
					} else{
						o[this.name] = this.value || '';
					}
				});
				return o;
			};

			var Books = Backbone.Collection.extend({
				url: '/books'
			});

			var Book = Backbone.Model.extend({
				urlRoot: '/books'
			});

			var BookList = Backbone.View.extend({
				el: '.bookAppPanel',
				render: function(){
					var that = this;
					var books = new Books();
					books.fetch({
						success: function(books){
							var template = _.template($('#book-list-template').html(), {books: books})
							that.$el.html(template);
						}
					});
					
				}
			});

			var EditBook = Backbone.View.extend({
				el: '.bookAppPanel',
				render: function (options){
					that = this;
					if(options.id){
						that.book = new Book({id: options.id});
						that.book.fetch({
							success: function(book){
								var template = _.template($('#edit-book-template').html(), {book: book})
								that.$el.html(template);
							}
						});
					} else{
						var template = _.template($('#edit-book-template').html(), {book: null})
						this.$el.html(template);
					}
				},
				events: {
					'submit .edit-book-form': 'saveBook',
					'click .delete': 'deleteBook'
				},
				saveBook: function(ev){
					var bookDetails = $(ev.currentTarget).SerializeObject();
					var book = new Book();
					book.save(bookDetails, {
						success: function(book){
							router.navigate('', {trigger: true});
						}
					});
					return false;
				},

				deleteBook: function (ev){
					this.book.destroy({
						success: function(book){
							router.navigate('', {trigger: true});
						}
					});
					return false;
				}
			});

			var booklist = new BookList();
			var editBook = new EditBook();

			var Router = Backbone.Router.extend({
				routes: {
					'': 'home',
					'new': 'editBook',
					'list': 'home',
					'edit/:id': 'editBook'
				}
			});
			var router = new Router();
			router.on('route:home', function(){
				booklist.render();
			});
			router.on('route:editBook', function (id){
				editBook.render({id: id});
			});
			Backbone.history.start();
		</script>

	</body>
</html>