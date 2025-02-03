<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;


class QuoteController extends Controller
{
    protected $quotes = [
        [
            'quote' => 'The greatest glory in living lies not in never falling, but in rising every time we fall.',
            'author' => 'Nelson Mandela'
        ],
        [
            'quote' => 'The way to get started is to quit talking and begin doing.',
            'author' => 'Walt Disney'
        ],
        [
            'quote' => 'Your time is limited, so don\'t waste it living someone else\'s life.',
            'author' => 'Steve Jobs'
        ],
        [
            'quote' => 'If life were predictable it would cease to be life, and be without flavor.',
            'author' => 'Eleanor Roosevelt'
        ],
        [
            'quote' => 'If you set your goals ridiculously high and it\'s a failure, you will fail above everyone else\'s success.',
            'author' => 'James Cameron'
        ],
        [
            'quote' => 'Life is what happens when you\'re busy making other plans.',
            'author' => 'John Lennon'
        ],
        [
            'quote' => 'Spread love everywhere you go. Let no one ever come to you without leaving happier.',
            'author' => 'Mother Teresa'
        ],
        [
            'quote' => 'Don\'t judge each day by the harvest you reap but by the seeds that you plant.',
            'author' => 'Robert Louis Stevenson'
        ],
        [
            'quote' => 'The future belongs to those who believe in the beauty of their dreams.',
            'author' => 'Eleanor Roosevelt'
        ],
        [
            'quote' => 'Tell me and I forget. Teach me and I remember. Involve me and I learn.',
            'author' => 'Benjamin Franklin'
        ],
        [
            'quote' => 'It is our choices that show what we truly are, far more than our abilities.',
            'author' => 'J.K. Rowling'
        ],
        [
            'quote' => 'Do not dwell in the past, do not dream of the future, concentrate the mind on the present moment.',
            'author' => 'Buddha'
        ],
        [
            'quote' => 'The only limit to our realization of tomorrow is our doubts of today.',
            'author' => 'Franklin D. Roosevelt'
        ],
        [
            'quote' => 'The purpose of our lives is to be happy.',
            'author' => 'Dalai Lama'
        ],
        [
            'quote' => 'Life is really simple, but we insist on making it complicated.',
            'author' => 'Confucius'
        ],
        [
            'quote' => 'Success is not final, failure is not fatal: It is the courage to continue that counts.',
            'author' => 'Winston Churchill'
        ],
        [
            'quote' => 'It is better to fail in originality than to succeed in imitation.',
            'author' => 'Herman Melville'
        ],
        [
            'quote' => 'The road to success and the road to failure are almost exactly the same.',
            'author' => 'Colin R. Davis'
        ],
        [
            'quote' => 'Success usually comes to those who are too busy to be looking for it.',
            'author' => 'Henry David Thoreau'
        ],
        [
            'quote' => 'Opportunities don’t happen. You create them.',
            'author' => 'Chris Grosser'
        ],
        [
            'quote' => 'Don’t be afraid to give up the good to go for the great.',
            'author' => 'John D. Rockefeller'
        ],
        [
            'quote' => 'I find that the harder I work, the more luck I seem to have.',
            'author' => 'Thomas Jefferson'
        ],
        [
            'quote' => 'Success is not in what you have, but who you are.',
            'author' => 'Bo Bennett'
        ],
        [
            'quote' => 'The only place where success comes before work is in the dictionary.',
            'author' => 'Vidal Sassoon'
        ],
        [
            'quote' => 'If you really look closely, most overnight successes took a long time.',
            'author' => 'Steve Jobs'
        ],
        [
            'quote' => 'The way to get started is to quit talking and begin doing.',
            'author' => 'Walt Disney'
        ],
        [
            'quote' => 'The successful warrior is the average man, with laser-like focus.',
            'author' => 'Bruce Lee'
        ],
        [
            'quote' => 'Success seems to be connected with action. Successful people keep moving.',
            'author' => 'Conrad Hilton'
        ],
        [
            'quote' => 'In order to succeed, we must first believe that we can.',
            'author' => 'Nikos Kazantzakis'
        ],
        [
            'quote' => 'The only limit to our realization of tomorrow is our doubts of today.',
            'author' => 'Franklin D. Roosevelt'
        ],
        [
            'quote' => 'The purpose of our lives is to be happy.',
            'author' => 'Dalai Lama'
        ],
        [
            'quote' => 'Life is what happens when you’re busy making other plans.',
            'author' => 'John Lennon'
        ],
        [
            'quote' => 'Get busy living or get busy dying.',
            'author' => 'Stephen King'
        ]


    ];
    public function getRandomQuote()
    {

        $quote = $this->quotes[rand(0, count($this->quotes) - 1)];

        return response()->json([
            'quote' => $quote['quote'],
            'author' => $quote['author']
        ]);
    }
}
