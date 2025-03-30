public function store(Request $request)
{
    // ...existing validation and vote storing logic...

    // Set session and cookie for voted status
    session(['has_voted' => true]);
    Cookie::queue('has_voted', true, 43200); // 30 days

    return redirect()->route('voter.voting.index')->with('success', 'Your vote has been recorded successfully!');
}
