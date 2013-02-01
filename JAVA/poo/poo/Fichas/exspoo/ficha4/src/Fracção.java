class mainFracção{
	
	public static void  main(String[] args){
		
		Fracção f1= new Fracção(User.readInt(), User.readInt());
		Fracção f2 = new Fracção();
		Fracção f3=new Fracção();
		
		f1 = f1.adição(f2);
			
		System.out.println(f3.toString());
	}
}
	
	class Fracção{
		int numerador=1;
		int denominador=1;
		Fracção() {};
		Fracção(int n, int d) {numerador = n; denominador = d;}
		
		Fracção(Fracção f) {numerador=f.numerador; denominador=f.denominador;}
		
		Fracção adição(Fracção f){
			return new Fracção (numerador * f.denominador + f.numerador * denominador, denominador*f.denominador); }
		String toSring() {return "" + numerador + "/" + denominador; }
	}
//subtracção, multiplicaçao e divisao
