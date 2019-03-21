# Game 01

Let M be a not empty set of integer numbers, find the first subset of 2 numbers of M which sum N.
For instance, let's say we've got a set of number [5, 2, 8, 14, 0] and N = 10, the resulting subset should be [2, 8].

## Challenge
You're required to create a function that receives an array (M) and integer value (N), this function has to return an array of the first possible solution

###Solución

- Se ha creado la función calculate_subset_arr el cual recibe como parámentros $M (vector) y $N (número que encontrar el subconjuto).
- $tmpArr es un vector temporal que almancena una copia de $M
- Se analizar cada uno de los valores de $M =[m1,m2,m3,m4,m5,m6....,mn]
   - En $m1: puede darse el caso el el número actual que se analiza se repita varias veces en el vector en diferentes posiciones.
   Por ejemplo: el vector podría ser [5,5,5,5,3,2,4,5]. Lo que se tendría que hacer es eliminar m1 del vector temporal $tmpArr,
   entoncesd quedaría [5,5,5,3,2,4,5].
- Debe verificarse que m1 sea menor o igual que $N
- $n es el valor que sumado a $m1 da igual a $N, entonces $n=$N-$m1
- Verificar si $n se encuentra en el vector temporal $tmpArr, si fuera el caso entonces $m1 y $n es el primer subconjunto que sumado es igual a $N 
   
  
   
   
    
  