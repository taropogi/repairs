<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quote;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quotes = [
            [
                'quote' => 'Simplicity is the ultimate sophistication.',
                'author' => 'Leonardo da Vinci'
            ],
            [
                'quote' => 'Success is not final, failure is not fatal: it is the courage to continue that counts.',
                'author' => 'Winston Churchill'
            ],
            [
                'quote' => 'The only limit to our realization of tomorrow is our doubts of today.',
                'author' => 'Franklin D. Roosevelt'
            ],
            // Add more quotes as needed
            [
                'quote' => 'Believe you can and you\'re halfway there.',
                'author' => 'Theodore Roosevelt'
            ],
            [
                'quote' => 'Act as if what you do makes a difference. It does.',
                'author' => 'William James'
            ],
            [
                'quote' => 'Success is not how high you have climbed, but how you make a positive difference to the world.',
                'author' => 'Roy T. Bennett'
            ],
            [
                'quote' => 'What you get by achieving your goals is not as important as what you become by achieving your goals.',
                'author' => 'Zig Ziglar'
            ],
            [
                'quote' => 'You are never too old to set another goal or to dream a new dream.',
                'author' => 'C.S. Lewis'
            ],
            [
                'quote' => 'The best way to predict the future is to invent it.',
                'author' => 'Alan Kay'
            ],
            [
                'quote' => 'Life is 10% what happens to us and 90% how we react to it.',
                'author' => 'Charles R. Swindoll'
            ],
            [
                'quote' => 'Your time is limited, don’t waste it living someone else’s life.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'If you can dream it, you can achieve it.',
                'author' => 'Zig Ziglar'
            ],
            [
                'quote' => 'The best revenge is massive success.',
                'author' => 'Frank Sinatra'
            ],
            [
                'quote' => 'Life is what happens when you’re busy making other plans.',
                'author' => 'John Lennon'
            ],
            [
                'quote' => 'The purpose of our lives is to be happy.',
                'author' => 'Dalai Lama'
            ],
            [
                'quote' => 'Get busy living or get busy dying.',
                'author' => 'Stephen King'
            ],
            [
                'quote' => 'You have within you right now, everything you need to deal with whatever the world can throw at you.',
                'author' => 'Brian Tracy'
            ],
            [
                'quote' => 'Believe you can and you’re halfway there.',
                'author' => 'Theodore Roosevelt'
            ],
            [
                'quote' => 'The only impossible journey is the one you never begin.',
                'author' => 'Tony Robbins'
            ],
            [
                'quote' => 'The future belongs to those who believe in the beauty of their dreams.',
                'author' => 'Eleanor Roosevelt'
            ],
            [
                'quote' => 'Do not watch the clock. Do what it does. Keep going.',
                'author' => 'Sam Levenson'
            ],
            [
                'quote' => 'Keep your face always toward the sunshine—and shadows will fall behind you.',
                'author' => 'Walt Whitman'
            ],
            [
                'quote' => 'The best way to get started is to quit talking and begin doing.',
                'author' => 'Walt Disney'
            ],
            [
                'quote' => 'Don’t let yesterday take up too much of today.',
                'author' => 'Will Rogers'
            ],
            [
                'quote' => 'You learn more from failure than from success. Don’t let it stop you. Failure builds character.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'It’s not whether you get knocked down, it’s whether you get up.',
                'author' => 'Vince Lombardi'
            ],
            [
                'quote' => 'If you are working on something that you really care about, you don’t have to be pushed. The vision pulls you.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'People who are crazy enough to think they can change the world, are the ones who do.',
                'author' => 'Rob Siltanen'
            ],
            [
                'quote' => 'Failure will never overtake me if my determination to succeed is strong enough.',
                'author' => 'Og Mandino'
            ],
            [
                'quote' => 'We may encounter many defeats but we must not be defeated.',
                'author' => 'Maya Angelou'
            ],
            [
                'quote' => 'Knowing is not enough; we must apply. Wishing is not enough; we must do.',
                'author' => 'Johann Wolfgang Von Goethe'
            ],
            [
                'quote' => 'Imagine your life is perfect in every respect; what would it look like?',
                'author' => 'Brian Tracy'
            ],
            [
                'quote' => 'We generate fears while we sit. We overcome them by action.',
                'author' => 'Dr. Henry Link'
            ],
            [
                'quote' => 'Whether you think you can or think you can’t, you’re right.',
                'author' => 'Henry Ford'
            ],
            [
                'quote' => 'Security is mostly a superstition. Life is either a daring adventure or nothing.',
                'author' => 'Helen Keller'
            ],
            [
                'quote' => 'The man who has confidence in himself gains the confidence of others.',
                'author' => 'Hasidic Proverb'
            ],
            [
                'quote' => 'The only limit to our realization of tomorrow is our doubts of today.',
                'author' => 'Franklin D. Roosevelt'
            ],
            [
                'quote' => 'Creativity is intelligence having fun.',
                'author' => 'Albert Einstein'
            ],
            [
                'quote' => 'What you lack in talent can be made up with desire, hustle and giving 110% all the time.',
                'author' => 'Don Zimmer'
            ],
            [
                'quote' => 'Do what you can with all you have, wherever you are.',
                'author' => 'Theodore Roosevelt'
            ],
            [
                'quote' => 'Develop an ‘Attitude of Gratitude’. Say thank you to everyone you meet for everything they do for you.',
                'author' => 'Brian Tracy'
            ],
            [
                'quote' => 'You are never too old to set another goal or to dream a new dream.',
                'author' => 'C.S. Lewis'
            ],
            [
                'quote' => 'To see what is right and not do it is a lack of courage.',
                'author' => 'Confucius'
            ],
            [
                'quote' => 'Reading is to the mind, as exercise is to the body.',
                'author' => 'Brian Tracy'
            ],
            [
                'quote' => 'Fake it until you make it! Act as if you had all the confidence you require until it becomes your reality.',
                'author' => 'Brian Tracy'
            ],
            [
                'quote' => 'The future belongs to the competent. Get good, get better, be the best!',
                'author' => 'Brian Tracy'
            ],
            [
                'quote' => 'For every reason it’s not possible, there are hundreds of people who have faced the same circumstances and succeeded.',
                'author' => 'Jack Canfield'
            ],
            [
                'quote' => 'Things work out best for those who make the best of how things work out.',
                'author' => 'John Wooden'
            ],
            [
                'quote' => 'A room without books is like a body without a soul.',
                'author' => 'Marcus Tullius Cicero'
            ],
            [
                'quote' => 'I think, therefore I am.',
                'author' => 'René Descartes'
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'The best way to predict the future is to create it.',
                'author' => 'Peter Drucker'
            ],
            [
                'quote' => 'You miss 100% of the shots you don’t take.',
                'author' => 'Wayne Gretzky'
            ],
            [
                'quote' => 'I have not failed. I’ve just found 10,000 ways that won’t work.',
                'author' => 'Thomas Edison'
            ],
            [
                'quote' => 'The best time to plant a tree was 20 years ago. The second best time is now.',
                'author' => 'Chinese Proverb'
            ],
            [
                'quote' => 'It does not matter how slowly you go as long as you do not stop.',
                'author' => 'Confucius'
            ],
            [
                'quote' => 'Everything you’ve ever wanted is on the other side of fear.',
                'author' => 'George Addair'
            ],
            [
                'quote' => 'Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful.',
                'author' => 'Albert Schweitzer'
            ],
            [
                'quote' => 'Dream big and dare to fail.',
                'author' => 'Norman Vaughan'
            ],
            [
                'quote' => 'Keep going. Be all in.',
                'author' => 'Bryan Hutchinson'
            ],
            [
                'quote' => 'Stay foolish to stay sane.',
                'author' => 'Maxime Lagacé'
            ],
            [
                'quote' => 'When nothing goes right, go left.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Try Again. Fail again. Fail better.',
                'author' => 'Samuel Beckett'
            ],
            [
                'quote' => 'Impossible is for the unwilling.',
                'author' => 'John Keats'
            ],
            [
                'quote' => 'No pressure, no diamonds.',
                'author' => 'Thomas Carlyle'
            ],
            [
                'quote' => 'Stay hungry. Stay foolish.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'Prove them wrong.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Keep going. Keep growing.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do it with passion or not at all.',
                'author' => 'Rosa Nouchette Carey'
            ],
            [
                'quote' => 'Whatever you are, be a good one.',
                'author' => 'Abraham Lincoln'
            ],
            [
                'quote' => 'What we think, we become.',
                'author' => 'Buddha'
            ],
            [
                'quote' => 'Dream without fear. Love without limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do more things that make you forget to check your phone.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The best is yet to come.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are enough just as you are.',
                'author' => 'Meghan Markle'
            ],
            [
                'quote' => 'You can if you think you can.',
                'author' => 'George Reeves'
            ],
            [
                'quote' => 'Don’t wait. The time will never be just right.',
                'author' => 'Napoleon Hill'
            ],
            [
                'quote' => 'You are stronger than you think.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in yourself and all that you are.',
                'author' => 'Christian D. Larson'
            ],
            [
                'quote' => 'You are never too old to set another goal or to dream a new dream.',
                'author' => 'C.S. Lewis'
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'The best way to predict the future is to create it.',
                'author' => 'Peter Drucker'
            ],
            [
                'quote' => 'You miss 100% of the shots you don’t take.',
                'author' => 'Wayne Gretzky'
            ],
            [
                'quote' => 'I have not failed. I’ve just found 10,000 ways that won’t work.',
                'author' => 'Thomas Edison'
            ],
            [
                'quote' => 'The best time to plant a tree was 20 years ago. The second best time is now.',
                'author' => 'Chinese Proverb'
            ],
            [
                'quote' => 'It does not matter how slowly you go as long as you do not stop.',
                'author' => 'Confucius'
            ],
            [
                'quote' => 'Everything you’ve ever wanted is on the other side of fear.',
                'author' => 'George Addair'
            ],
            [
                'quote' => 'Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful.',
                'author' => 'Albert Schweitzer'
            ],
            [
                'quote' => 'Dream big and dare to fail.',
                'author' => 'Norman Vaughan'
            ],
            [
                'quote' => 'Keep going. Be all in.',
                'author' => 'Bryan Hutchinson'
            ],
            [
                'quote' => 'Stay foolish to stay sane.',
                'author' => 'Maxime Lagacé'
            ],
            [
                'quote' => 'When nothing goes right, go left.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Try Again. Fail again. Fail better.',
                'author' => 'Samuel Beckett'
            ],
            [
                'quote' => 'Impossible is for the unwilling.',
                'author' => 'John Keats'
            ],
            [
                'quote' => 'No pressure, no diamonds.',
                'author' => 'Thomas Carlyle'
            ],
            [
                'quote' => 'Stay hungry. Stay foolish.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'Prove them wrong.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Keep going. Keep growing.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do it with passion or not at all.',
                'author' => 'Rosa Nouchette Carey'
            ],
            [
                'quote' => 'Whatever you are, be a good one.',
                'author' => 'Abraham Lincoln'
            ],
            [
                'quote' => 'What we think, we become.',
                'author' => 'Buddha'
            ],
            [
                'quote' => 'Dream without fear. Love without limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do more things that make you forget to check your phone.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The best is yet to come.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are enough just as you are.',
                'author' => 'Meghan Markle'
            ],
            [
                'quote' => 'You can if you think you can.',
                'author' => 'George Reeves'
            ],
            [
                'quote' => 'Don’t wait. The time will never be just right.',
                'author' => 'Napoleon Hill'
            ],
            [
                'quote' => 'You are stronger than you think.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in yourself and all that you are.',
                'author' => 'Christian D. Larson'
            ],
            [
                'quote' => 'You are never too old to set another goal or to dream a new dream.',
                'author' => 'C.S. Lewis'
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'The best way to predict the future is to create it.',
                'author' => 'Peter Drucker'
            ],
            [
                'quote' => 'You miss 100% of the shots you don’t take.',
                'author' => 'Wayne Gretzky'
            ],
            [
                'quote' => 'I have not failed. I’ve just found 10,000 ways that won’t work.',
                'author' => 'Thomas Edison'
            ],
            [
                'quote' => 'The best time to plant a tree was 20 years ago. The second best time is now.',
                'author' => 'Chinese Proverb'
            ],
            [
                'quote' => 'It does not matter how slowly you go as long as you do not stop.',
                'author' => 'Confucius'
            ],
            [
                'quote' => 'Everything you’ve ever wanted is on the other side of fear.',
                'author' => 'George Addair'
            ],
            [
                'quote' => 'Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful.',
                'author' => 'Albert Schweitzer'
            ],
            [
                'quote' => 'Dream big and dare to fail.',
                'author' => 'Norman Vaughan'
            ],
            [
                'quote' => 'Keep going. Be all in.',
                'author' => 'Bryan Hutchinson'
            ],
            [
                'quote' => 'Stay foolish to stay sane.',
                'author' => 'Maxime Lagacé'
            ],
            [
                'quote' => 'When nothing goes right, go left.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Try Again. Fail again. Fail better.',
                'author' => 'Samuel Beckett'
            ],
            [
                'quote' => 'Impossible is for the unwilling.',
                'author' => 'John Keats'
            ],
            [
                'quote' => 'No pressure, no diamonds.',
                'author' => 'Thomas Carlyle'
            ],
            [
                'quote' => 'Stay hungry. Stay foolish.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'Prove them wrong.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Keep going. Keep growing.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do it with passion or not at all.',
                'author' => 'Rosa Nouchette Carey'
            ],
            [
                'quote' => 'Whatever you are, be a good one.',
                'author' => 'Abraham Lincoln'
            ],
            [
                'quote' => 'What we think, we become.',
                'author' => 'Buddha'
            ],
            [
                'quote' => 'Dream without fear. Love without limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do more things that make you forget to check your phone.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The best is yet to come.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are enough just as you are.',
                'author' => 'Meghan Markle'
            ],
            [
                'quote' => 'You can if you think you can.',
                'author' => 'George Reeves'
            ],
            [
                'quote' => 'Don’t wait. The time will never be just right.',
                'author' => 'Napoleon Hill'
            ],
            [
                'quote' => 'You are stronger than you think.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in yourself and all that you are.',
                'author' => 'Christian D. Larson'
            ],
            [
                'quote' => 'You are never too old to set another goal or to dream a new dream.',
                'author' => 'C.S. Lewis'
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'The best way to predict the future is to create it.',
                'author' => 'Peter Drucker'
            ],
            [
                'quote' => 'You miss 100% of the shots you don’t take.',
                'author' => 'Wayne Gretzky'
            ],
            [
                'quote' => 'I have not failed. I’ve just found 10,000 ways that won’t work.',
                'author' => 'Thomas Edison'
            ],
            [
                'quote' => 'The best time to plant a tree was 20 years ago. The second best time is now.',
                'author' => 'Chinese Proverb'
            ],
            [
                'quote' => 'It does not matter how slowly you go as long as you do not stop.',
                'author' => 'Confucius'
            ],
            [
                'quote' => 'Everything you’ve ever wanted is on the other side of fear.',
                'author' => 'George Addair'
            ],
            [
                'quote' => 'Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful.',
                'author' => 'Albert Schweitzer'
            ],
            [
                'quote' => 'Dream big and dare to fail.',
                'author' => 'Norman Vaughan'
            ],
            [
                'quote' => 'Keep going. Be all in.',
                'author' => 'Bryan Hutchinson'
            ],
            [
                'quote' => 'Stay foolish to stay sane.',
                'author' => 'Maxime Lagacé'
            ],
            [
                'quote' => 'When nothing goes right, go left.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Try Again. Fail again. Fail better.',
                'author' => 'Samuel Beckett'
            ],
            [
                'quote' => 'Impossible is for the unwilling.',
                'author' => 'John Keats'
            ],
            [
                'quote' => 'No pressure, no diamonds.',
                'author' => 'Thomas Carlyle'
            ],
            [
                'quote' => 'Stay hungry. Stay foolish.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'Prove them wrong.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Keep going. Keep growing.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do it with passion or not at all.',
                'author' => 'Rosa Nouchette Carey'
            ],
            [
                'quote' => 'Whatever you are, be a good one.',
                'author' => 'Abraham Lincoln'
            ],
            [
                'quote' => 'What we think, we become.',
                'author' => 'Buddha'
            ],
            [
                'quote' => 'Dream without fear. Love without limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do more things that make you forget to check your phone.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The best is yet to come.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are enough just as you are.',
                'author' => 'Meghan Markle'
            ],
            [
                'quote' => 'You can if you think you can.',
                'author' => 'George Reeves'
            ],
            [
                'quote' => 'Don’t wait. The time will never be just right.',
                'author' => 'Napoleon Hill'
            ],
            [
                'quote' => 'You are stronger than you think.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in yourself and all that you are.',
                'author' => 'Christian D. Larson'
            ],
            [
                'quote' => 'You are never too old to set another goal or to dream a new dream.',
                'author' => 'C.S. Lewis'
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'The best way to predict the future is to create it.',
                'author' => 'Peter Drucker'
            ],
            [
                'quote' => 'You miss 100% of the shots you don’t take.',
                'author' => 'Wayne Gretzky'
            ],
            [
                'quote' => 'I have not failed. I’ve just found 10,000 ways that won’t work.',
                'author' => 'Thomas Edison'
            ],
            [
                'quote' => 'The best time to plant a tree was 20 years ago. The second best time is now.',
                'author' => 'Chinese Proverb'
            ],
            [
                'quote' => 'It does not matter how slowly you go as long as you do not stop.',
                'author' => 'Confucius'
            ],
            [
                'quote' => 'Everything you’ve ever wanted is on the other side of fear.',
                'author' => 'George Addair'
            ],
            [
                'quote' => 'Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful.',
                'author' => 'Albert Schweitzer'
            ],
            [
                'quote' => 'Dream big and dare to fail.',
                'author' => 'Norman Vaughan'
            ],
            [
                'quote' => 'Keep going. Be all in.',
                'author' => 'Bryan Hutchinson'
            ],
            [
                'quote' => 'Stay foolish to stay sane.',
                'author' => 'Maxime Lagacé'
            ],
            [
                'quote' => 'When nothing goes right, go left.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Try Again. Fail again. Fail better.',
                'author' => 'Samuel Beckett'
            ],
            [
                'quote' => 'Impossible is for the unwilling.',
                'author' => 'John Keats'
            ],
            [
                'quote' => 'No pressure, no diamonds.',
                'author' => 'Thomas Carlyle'
            ],
            [
                'quote' => 'Stay hungry. Stay foolish.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'Prove them wrong.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Keep going. Keep growing.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do it with passion or not at all.',
                'author' => 'Rosa Nouchette Carey'
            ],
            [
                'quote' => 'Whatever you are, be a good one.',
                'author' => 'Abraham Lincoln'
            ],
            [
                'quote' => 'What we think, we become.',
                'author' => 'Buddha'
            ],
            [
                'quote' => 'Dream without fear. Love without limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do more things that make you forget to check your phone.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The best is yet to come.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are enough just as you are.',
                'author' => 'Meghan Markle'
            ],
            [
                'quote' => 'You can if you think you can.',
                'author' => 'George Reeves'
            ],
            [
                'quote' => 'Don’t wait. The time will never be just right.',
                'author' => 'Napoleon Hill'
            ],
            [
                'quote' => 'You are stronger than you think.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in yourself and all that you are.',
                'author' => 'Christian D. Larson'
            ],
            [
                'quote' => 'You are never too old to set another goal or to dream a new dream.',
                'author' => 'C.S. Lewis'
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'The best way to predict the future is to create it.',
                'author' => 'Peter Drucker'
            ],
            [
                'quote' => 'You miss 100% of the shots you don’t take.',
                'author' => 'Wayne Gretzky'
            ],
            [
                'quote' => 'I have not failed. I’ve just found 10,000 ways that won’t work.',
                'author' => 'Thomas Edison'
            ],
            [
                'quote' => 'The best time to plant a tree was 20 years ago. The second best time is now.',
                'author' => 'Chinese Proverb'
            ],
            [
                'quote' => 'It does not matter how slowly you go as long as you do not stop.',
                'author' => 'Confucius'
            ],
            [
                'quote' => 'Everything you’ve ever wanted is on the other side of fear.',
                'author' => 'George Addair'
            ],
            [
                'quote' => 'Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful.',
                'author' => 'Albert Schweitzer'
            ],
            [
                'quote' => 'Dream big and dare to fail.',
                'author' => 'Norman Vaughan'
            ],
            [
                'quote' => 'Keep going. Be all in.',
                'author' => 'Bryan Hutchinson'
            ],
            [
                'quote' => 'Stay foolish to stay sane.',
                'author' => 'Maxime Lagacé'
            ],
            [
                'quote' => 'When nothing goes right, go left.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Try Again. Fail again. Fail better.',
                'author' => 'Samuel Beckett'
            ],
            [
                'quote' => 'Impossible is for the unwilling.',
                'author' => 'John Keats'
            ],
            [
                'quote' => 'No pressure, no diamonds.',
                'author' => 'Thomas Carlyle'
            ],
            [
                'quote' => 'Stay hungry. Stay foolish.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'Prove them wrong.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Keep going. Keep growing.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do it with passion or not at all.',
                'author' => 'Rosa Nouchette Carey'
            ],
            [
                'quote' => 'Whatever you are, be a good one.',
                'author' => 'Abraham Lincoln'
            ],
            [
                'quote' => 'What we think, we become.',
                'author' => 'Buddha'
            ],
            [
                'quote' => 'Dream without fear. Love without limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do more things that make you forget to check your phone.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The best is yet to come.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are enough just as you are.',
                'author' => 'Meghan Markle'
            ],
            [
                'quote' => 'You can if you think you can.',
                'author' => 'George Reeves'
            ],
            [
                'quote' => 'Don’t wait. The time will never be just right.',
                'author' => 'Napoleon Hill'
            ],
            [
                'quote' => 'You are stronger than you think.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in yourself and all that you are.',
                'author' => 'Christian D. Larson'
            ],
            [
                'quote' => 'You are never too old to set another goal or to dream a new dream.',
                'author' => 'C.S. Lewis'
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'The best way to predict the future is to create it.',
                'author' => 'Peter Drucker'
            ],
            [
                'quote' => 'You miss 100% of the shots you don’t take.',
                'author' => 'Wayne Gretzky'
            ],
            [
                'quote' => 'I have not failed. I’ve just found 10,000 ways that won’t work.',
                'author' => 'Thomas Edison'
            ],
            [
                'quote' => 'The best time to plant a tree was 20 years ago. The second best time is now.',
                'author' => 'Chinese Proverb'
            ],
            [
                'quote' => 'It does not matter how slowly you go as long as you do not stop.',
                'author' => 'Confucius'
            ],
            [
                'quote' => 'Everything you’ve ever wanted is on the other side of fear.',
                'author' => 'George Addair'
            ],
            [
                'quote' => 'Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful.',
                'author' => 'Albert Schweitzer'
            ],
            [
                'quote' => 'Dream big and dare to fail.',
                'author' => 'Norman Vaughan'
            ],
            [
                'quote' => 'Keep going. Be all in.',
                'author' => 'Bryan Hutchinson'
            ],
            [
                'quote' => 'Stay foolish to stay sane.',
                'author' => 'Maxime Lagacé'
            ],
            [
                'quote' => 'When nothing goes right, go left.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Try Again. Fail again. Fail better.',
                'author' => 'Samuel Beckett'
            ],
            [
                'quote' => 'Impossible is for the unwilling.',
                'author' => 'John Keats'
            ],
            [
                'quote' => 'No pressure, no diamonds.',
                'author' => 'Thomas Carlyle'
            ],
            [
                'quote' => 'Stay hungry. Stay foolish.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'Prove them wrong.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Keep going. Keep growing.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do it with passion or not at all.',
                'author' => 'Rosa Nouchette Carey'
            ],
            [
                'quote' => 'Whatever you are, be a good one.',
                'author' => 'Abraham Lincoln'
            ],
            [
                'quote' => 'What we think, we become.',
                'author' => 'Buddha'
            ],
            [
                'quote' => 'Dream without fear. Love without limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do more things that make you forget to check your phone.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The best is yet to come.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are enough just as you are.',
                'author' => 'Meghan Markle'
            ],
            [
                'quote' => 'You can if you think you can.',
                'author' => 'George Reeves'
            ],
            [
                'quote' => 'Don’t wait. The time will never be just right.',
                'author' => 'Napoleon Hill'
            ],
            [
                'quote' => 'You are stronger than you think.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in yourself and all that you are.',
                'author' => 'Christian D. Larson'
            ],
            [
                'quote' => 'You are never too old to set another goal or to dream a new dream.',
                'author' => 'C.S. Lewis'
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'The best way to predict the future is to create it.',
                'author' => 'Peter Drucker'
            ],
            [
                'quote' => 'You miss 100% of the shots you don’t take.',
                'author' => 'Wayne Gretzky'
            ],
            [
                'quote' => 'I have not failed. I’ve just found 10,000 ways that won’t work.',
                'author' => 'Thomas Edison'
            ],
            [
                'quote' => 'The best time to plant a tree was 20 years ago. The second best time is now.',
                'author' => 'Chinese Proverb'
            ],
            [
                'quote' => 'It does not matter how slowly you go as long as you do not stop.',
                'author' => 'Confucius'
            ],
            [
                'quote' => 'Everything you’ve ever wanted is on the other side of fear.',
                'author' => 'George Addair'
            ],
            [
                'quote' => 'Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful.',
                'author' => 'Albert Schweitzer'
            ],
            [
                'quote' => 'Dream big and dare to fail.',
                'author' => 'Norman Vaughan'
            ],
            [
                'quote' => 'Keep going. Be all in.',
                'author' => 'Bryan Hutchinson'
            ],
            [
                'quote' => 'Stay foolish to stay sane.',
                'author' => 'Maxime Lagacé'
            ],
            [
                'quote' => 'When nothing goes right, go left.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Try Again. Fail again. Fail better.',
                'author' => 'Samuel Beckett'
            ],
            [
                'quote' => 'Impossible is for the unwilling.',
                'author' => 'John Keats'
            ],
            [
                'quote' => 'No pressure, no diamonds.',
                'author' => 'Thomas Carlyle'
            ],
            [
                'quote' => 'Stay hungry. Stay foolish.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'Prove them wrong.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Keep going. Keep growing.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do it with passion or not at all.',
                'author' => 'Rosa Nouchette Carey'
            ],
            [
                'quote' => 'Whatever you are, be a good one.',
                'author' => 'Abraham Lincoln'
            ],
            [
                'quote' => 'Be yourself; everyone else is already taken.',
                'author' => 'Oscar Wilde'
            ],
            [
                'quote' => 'To be, or not to be, that is the question.',
                'author' => 'William Shakespeare'
            ],
            [
                'quote' => 'The only thing we have to fear is fear itself.',
                'author' => 'Franklin D. Roosevelt'
            ],
            [
                'quote' => 'In the end, we only regret the chances we didn’t take.',
                'author' => 'Lewis Carroll'
            ],
            [
                'quote' => 'The journey of a thousand miles begins with one step.',
                'author' => 'Lao Tzu'
            ],
            [
                'quote' => 'That which does not kill us makes us stronger.',
                'author' => 'Friedrich Nietzsche'
            ],
            [
                'quote' => 'Life is what happens when you’re busy making other plans.',
                'author' => 'John Lennon'
            ],
            [
                'quote' => 'To live is the rarest thing in the world. Most people exist, that is all.',
                'author' => 'Oscar Wilde'
            ],
            [
                'quote' => 'Good things come to those who wait.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The best way to find yourself is to lose yourself in the service of others.',
                'author' => 'Mahatma Gandhi'
            ],
            [
                'quote' => 'The only way to achieve the impossible is to believe it is possible.',
                'author' => 'Charles Kingsleigh'
            ],
            [
                'quote' => 'Don’t watch the clock; do what it does. Keep going.',
                'author' => 'Sam Levenson'
            ],
            [
                'quote' => 'You are never too old to set another goal or to dream a new dream.',
                'author' => 'C.S. Lewis'
            ],
            [
                'quote' => 'The harder you work for something, the greater you’ll feel when you achieve it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Dream it. Wish it. Do it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Success doesn’t just find you. You have to go out and get it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The key to success is to focus on goals, not obstacles.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Dream bigger. Do bigger.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t stop when you’re tired. Stop when you’re done.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Wake up with determination. Go to bed with satisfaction.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do something today that your future self will thank you for.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Little things make big days.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'It’s going to be hard, but hard does not mean impossible.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t wait for opportunity. Create it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Sometimes we’re tested not to show our weaknesses, but to discover our strengths.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The key to success is to start before you are ready.',
                'author' => 'Marie Forleo'
            ],
            [
                'quote' => 'The only way to achieve the impossible is to believe it is possible.',
                'author' => 'Charles Kingsleigh'
            ],
            [
                'quote' => 'Don’t watch the clock; do what it does. Keep going.',
                'author' => 'Sam Levenson'
            ],
            [
                'quote' => 'The harder you work for something, the greater you’ll feel when you achieve it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Dream it. Wish it. Do it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Success doesn’t just find you. You have to go out and get it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The key to success is to focus on goals, not obstacles.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Dream bigger. Do bigger.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t stop when you’re tired. Stop when you’re done.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Wake up with determination. Go to bed with satisfaction.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do something today that your future self will thank you for.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Little things make big days.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'It’s going to be hard, but hard does not mean impossible.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t wait for opportunity. Create it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Sometimes we’re tested not to show our weaknesses, but to discover our strengths.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The key to success is to start before you are ready.',
                'author' => 'Marie Forleo'
            ],
            [
                'quote' => 'You are capable of amazing things.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in the power of yet.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Start where you are. Use what you have. Do what you can.',
                'author' => 'Arthur Ashe'
            ],
            [
                'quote' => 'The best view comes after the hardest climb.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t limit your challenges. Challenge your limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are your only limit.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are capable of amazing things.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in the power of yet.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Start where you are. Use what you have. Do what you can.',
                'author' => 'Arthur Ashe'
            ],
            [
                'quote' => 'The best view comes after the hardest climb.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t limit your challenges. Challenge your limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are your only limit.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are capable of amazing things.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in the power of yet.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Start where you are. Use what you have. Do what you can.',
                'author' => 'Arthur Ashe'
            ],
            [
                'quote' => 'The best view comes after the hardest climb.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t limit your challenges. Challenge your limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are your only limit.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are capable of amazing things.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in the power of yet.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Start where you are. Use what you have. Do what you can.',
                'author' => 'Arthur Ashe'
            ],
            [
                'quote' => 'The best view comes after the hardest climb.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t limit your challenges. Challenge your limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are your only limit.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are capable of amazing things.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The best way out is always through.',
                'author' => 'Robert Frost'
            ],
            [
                'quote' => 'What we think, we become.',
                'author' => 'Buddha'
            ],
            [
                'quote' => 'The only limit to our realization of tomorrow is our doubts of today.',
                'author' => 'Franklin D. Roosevelt'
            ],
            [
                'quote' => 'Act as if what you do makes a difference. It does.',
                'author' => 'William James'
            ],
            [
                'quote' => 'Success is not how high you have climbed, but how you make a positive difference to the world.',
                'author' => 'Roy T. Bennett'
            ],
            [
                'quote' => 'Believe you can and you’re halfway there.',
                'author' => 'Theodore Roosevelt'
            ],
            [
                'quote' => 'The best way to predict the future is to invent it.',
                'author' => 'Alan Kay'
            ],
            [
                'quote' => 'Life is 10% what happens to us and 90% how we react to it.',
                'author' => 'Charles R. Swindoll'
            ],
            [
                'quote' => 'Your time is limited, don’t waste it living someone else’s life.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'The only way to do great work is to love what you do.',
                'author' => 'Steve Jobs'
            ],
            [
                'quote' => 'If you can dream it, you can achieve it.',
                'author' => 'Zig Ziglar'
            ],
            [
                'quote' => 'The best revenge is massive success.',
                'author' => 'Frank Sinatra'
            ],
            [
                'quote' => 'Life is what happens when you’re busy making other plans.',
                'author' => 'John Lennon'
            ],
            [
                'quote' => 'The purpose of our lives is to be happy.',
                'author' => 'Dalai Lama'
            ],
            [
                'quote' => 'Get busy living or get busy dying.',
                'author' => 'Stephen King'
            ],
            [
                'quote' => 'You have within you right now, everything you need to deal with whatever the world can throw at you.',
                'author' => 'Brian Tracy'
            ],
            [
                'quote' => 'The only impossible journey is the one you never begin.',
                'author' => 'Tony Robbins'
            ],
            [
                'quote' => 'The future belongs to those who believe in the beauty of their dreams.',
                'author' => 'Eleanor Roosevelt'
            ],
            [
                'quote' => 'Do not watch the clock. Do what it does. Keep going.',
                'author' => 'Sam Levenson'
            ],
            [
                'quote' => 'Keep your face always toward the sunshine—and shadows will fall behind you.',
                'author' => 'Walt Whitman'
            ],
            [
                'quote' => 'Be yourself; everyone else is already taken.',
                'author' => 'Oscar Wilde'
            ],
            [
                'quote' => 'To be, or not to be, that is the question.',
                'author' => 'William Shakespeare'
            ],
            [
                'quote' => 'The only thing we have to fear is fear itself.',
                'author' => 'Franklin D. Roosevelt'
            ],
            [
                'quote' => 'In the end, we only regret the chances we didn’t take.',
                'author' => 'Lewis Carroll'
            ],
            [
                'quote' => 'The journey of a thousand miles begins with one step.',
                'author' => 'Lao Tzu'
            ],
            [
                'quote' => 'That which does not kill us makes us stronger.',
                'author' => 'Friedrich Nietzsche'
            ],
            [
                'quote' => 'To live is the rarest thing in the world. Most people exist, that is all.',
                'author' => 'Oscar Wilde'
            ],
            [
                'quote' => 'Good things come to those who wait.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The best way to find yourself is to lose yourself in the service of others.',
                'author' => 'Mahatma Gandhi'
            ],
            [
                'quote' => 'The only way to achieve the impossible is to believe it is possible.',
                'author' => 'Charles Kingsleigh'
            ],
            [
                'quote' => 'Don’t watch the clock; do what it does. Keep going.',
                'author' => 'Sam Levenson'
            ],
            [
                'quote' => 'The harder you work for something, the greater you’ll feel when you achieve it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Dream it. Wish it. Do it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Success doesn’t just find you. You have to go out and get it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The key to success is to focus on goals, not obstacles.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Dream bigger. Do bigger.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t stop when you’re tired. Stop when you’re done.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Wake up with determination. Go to bed with satisfaction.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Do something today that your future self will thank you for.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Little things make big days.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'It’s going to be hard, but hard does not mean impossible.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t wait for opportunity. Create it.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Sometimes we’re tested not to show our weaknesses, but to discover our strengths.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'The key to success is to start before you are ready.',
                'author' => 'Marie Forleo'
            ],
            [
                'quote' => 'You are capable of amazing things.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Believe in the power of yet.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Start where you are. Use what you have. Do what you can.',
                'author' => 'Arthur Ashe'
            ],
            [
                'quote' => 'The best view comes after the hardest climb.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'Don’t limit your challenges. Challenge your limits.',
                'author' => 'Unknown'
            ],
            [
                'quote' => 'You are your only limit.',
                'author' => 'Unknown'
            ]

        ];

        foreach ($quotes as $quote) {
            if (Quote::where('quote', $quote['quote'])->exists()) {
                continue;
            }
            Quote::create($quote);
        }
    }
}
