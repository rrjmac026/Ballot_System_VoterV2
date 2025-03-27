public function up()
{
    Schema::create('casted_votes', function (Blueprint $table) {
        $table->id('casted_vote_id');
        $table->string('transaction_number');
        $table->foreignId('voter_id')->constrained('voters');
        $table->foreignId('position_id')->constrained('positions');
        $table->foreignId('candidate_id')->constrained('candidates');
        $table->string('vote_hash');
        $table->timestamp('voted_at');
        $table->string('ip_address')->nullable();
        $table->string('user_agent')->nullable();
        $table->timestamps();
    });
}
