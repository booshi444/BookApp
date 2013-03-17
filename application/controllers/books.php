<?php

class Books_Controller extends Base_Controller {

  public $restful = true;


  public function get_index($id = null) {
    if(isset($_GET['book_name'])){
      $bookname = $_GET['book_name'];
      //$searchedBooks = DB::table('books')->where('book_name', 'LIKE', $bookname);
      $searchedBooks = Book::where('book_name', '=', $bookname)->first();
      if(is_null($searchedBooks)){
        $temp = new Book();
        return $temp->toJson();
      } else {
        return $searchedBooks->toJson();
      }
    }
    else if(is_null($id)){
      $allBooks = Book::all();
      return BaseModel::allToJson($allBooks);
    }
    else{
      $book = Book::find($id);
      return $book->toJson();
    }
  }

  /*public function get_index($id = null) {
    if(is_null($id)){
      $allBooks = Book::all();
      return BaseModel::allToJson($allBooks);
    }
    else{
      $book = Book::find($id);
      return $book->toJson();
    }
  }*/

  public function post_index() {
    $book = Input::json();
    $dbBook = new Book();
    $dbBook->book_name = $book->book_name;
    $dbBook->author_name = $book->author_name;
    $dbBook->is_read = $book->is_read;
    $dbBook->save();
    return $dbBook->toJson();
  }

  public function put_index() {
    $book = Input::json();
    $dbBook = Book::find($book->id);
    $dbBook->book_name = $book->book_name;
    $dbBook->author_name = $book->author_name;
    $dbBook->is_read = $book->is_read;
    $dbBook->save();
    return $dbBook->toJson();
  }

  public function delete_index($id = null) {
    $dbBook = Book::find($id);
    $dbBook->delete();
    return $dbBook->toJson();
  }

}
?>

