package Ficha4_2;


class Fraccao {
	
	int numerador=1;
	int denominador=1;
	
	//constructores
	Fraccao() {

	}
	
	Fraccao(int n, int d){
		numerador = n;
		denominador = d;
	}

	
	Fraccao(Fraccao f){
		numerador = f.numerador;
		denominador = f.denominador;
	}
	
	Fraccao adicao(Fraccao f){
		return new Fraccao (numerador * f.denominador + f.numerador * denominador, denominador * f.denominador ); 
	}
	
	Fraccao sub(Fraccao f){
		return new Fraccao (numerador * f.denominador - f.numerador * denominador, denominador * f.denominador ); 
	}
	Fraccao mul(Fraccao f){
		return new Fraccao (numerador * f.denominador - f.numerador * denominador, denominador * f.denominador ); 
	}
	Fraccao div(Fraccao f){
		return new Fraccao (numerador * f.denominador - f.numerador * denominador, denominador * f.denominador ); 
	}
	void print() {
		System.out.println(numerador + "/" + denominador);
	}
	
}