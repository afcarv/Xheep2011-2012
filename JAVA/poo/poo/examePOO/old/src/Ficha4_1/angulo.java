package Ficha4_1;



class angulo {               //� a classe angulo
	
	double graus;
	 //construtores nao t�m void nem nada a devolver!
	public angulo() {       //se o utilizador chamar Angulo() graus vai ser = 0
		graus=0;
	}
	public angulo(double graus){//se o user chamar Angulo(a1) graus vai ter o valor de a1
		this.graus=graus; //this porque ha duas variaveis com o mesmo nome.quer dizer que quero atribuir ao graus q ta fpra do bloco (double graus), o valor
	}
	
	public/*tipo q devolve*/angulo /*nome do metodo*/adicao /*tipo do argumento*/(angulo x){
		angulo saida;
		saida = new angulo();
		saida.graus = x.graus + this.graus;//podia ficar dentro de Angulo
		return saida;
	}
	public angulo subtrair(angulo x2){
		angulo saida2;
		saida2 = new angulo();
		saida2.graus = x2.graus - this.graus;
		return saida2;
	}
	double radianos(){
		return Math.toRadians(graus);
	}
	boolean equals(angulo x3){
		return graus == x3.graus;// uma vez que o angulo qu vou comparar j� � do tipo graus e est� em graus comparo com o angulo de entrada x3 da classe Angulo passado a graus
	}
	double sin(){
		return Math.sin(graus);
	}
	double cos(){
		return Math.cos(graus);
	}
	double tan(){
		return Math.tan(graus);
	}
	public String toString(){
		return "angulo de" + graus + " graus";
	}	
}