

class Angulo {               //é a classe angulo
	
	double graus;
	 //construtores nao têm void nem nada a devolver!
	public Angulo() {       //se o utilizador chamar Angulo() graus vai ser = 0
		graus=0;
	}
	public Angulo(double graus){//se o user chamar Angulo(a1) graus vai ter o valor de a1
		this.graus=graus; //this porque ha duas variaveis com o mesmo nome.quer dizer que quero atribuir ao graus q ta fpra do bloco (double graus), o valor
	}
	
	public/*tipo q devolve*/Angulo /*nome do metodo*/adicao /*tipo do argumento*/(Angulo x){
		Angulo saida;
		saida = new Angulo();
		saida.graus = x.graus + this.graus;//podia ficar dentro de Angulo
		return saida;
	}
	public Angulo subtrair(Angulo x2){
		Angulo saida2;
		saida2 = new Angulo();
		saida2.graus = x2.graus - this.graus;
		return saida2;
	}
	double radianos(){
		return Math.toRadians(graus);
	}
	boolean equals(Angulo x3){
		return graus == x3.graus;// uma vez que o angulo qu vou comparar já é do tipo graus e está em graus comparo com o angulo de entrada x3 da classe Angulo passado a graus
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