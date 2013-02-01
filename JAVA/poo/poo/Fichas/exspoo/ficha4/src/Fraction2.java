
class Fraction2 {
	
	int numerador=1;
	int denominador=1;
	
	//constructores
	Fraction2() {

	}
	
	Fraction2(int n, int d){
		numerador = n;
		denominador = d;
	}

	
	Fraction2(Fraction2 f){
		numerador = f.numerador;
		denominador = f.denominador;
	}
	
	Fraction2 adicao(Fraction2 f){
		return new Fraction2 (numerador * f.denominador + f.numerador * denominador, denominador * f.denominador ); 
	}
	
	void print() {
		System.out.println(numerador + "/" + denominador);
	}
	
}