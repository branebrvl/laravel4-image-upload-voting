<?php
class BookController extends BaseController {

	public function getIndex()
	{
    start('run-books-all', 'Getting all book');
    $books = Book::with('author')->get()->toArray();
    stop('run-books-all');

    l($books);

		// return View::make('book_list')->with('books',$books);
		return View::make('book_list')->with(compact('books'));
	}

}
