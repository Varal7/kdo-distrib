# kdo-distrib

kdo-distrib helps you organize gift exchange parties.

Traditionally, each player writes down his name on a piece of paper and throws it in a basket. Each person gets to pick a paper which determines who he will give a gift to.

kdo-distrib simulates such a distribution.

kdo-distrib uses Sattolo's algorithm, such that the resulting permutation is actually a n-cycle. This way, if player A can't make it, we don't need to shuffle again. B->A->C becomes B->C.
