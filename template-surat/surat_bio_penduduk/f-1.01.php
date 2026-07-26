<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<style type="text/css">
	table.disdukcapil
	{
		width: 100%;
		/*border-collapse: collapse;*/
	}
	table.disdukcapil td
	{
		padding: 1px 1px 1px 3px;
	}
	table.disdukcapil td.padat
	{
		padding: 0px;
		margin: 0px;
	}
	table.disdukcapil td.kotak
	{
		border: solid 1px #000000;
	}
	table.disdukcapil td.anggota
	{
		border-left: solid 1px #000000;
		border-right: solid 1px #000000;
		border-top: dashed 1px #000000;
		border-bottom: dashed 1px #000000;
	}
	table.disdukcapil td.judul
	{
		border-left: solid 1px #000000;
		border-right: solid 1px #000000;
		border-top: double 1px #000000;
		border-bottom: double 1px #000000;
	}
	table.disdukcapil td.bawah
	{
		border-left: solid 1px #000000;
		border-right: solid 1px #000000;
		border-top: dashed 1px #000000;
		border-bottom: double 1px #000000;
	}
		table.disdukcapil td.hitam
	{
		background-color: black;
	}
	table.disdukcapil td.abu
	{
		background-color: lightgrey;
	}
	table.disdukcapil td.kode {
		background-color: lightgrey;
	}
	table.disdukcapil td.kode div
	{
		margin: 0px 15px 0px 15px;
		border: solid 1px black;
		background-color: white;
		text-align: center;
	}
	table.disdukcapil td.pakai-padding
	{
		padding-left: 20px;
		padding-right: 2px;
	}
	table.disdukcapil td.kanan { text-align: right; }
	table.disdukcapil td.tengah { text-align: center; }

	table.ttd
	{
		margin-top: 20px;
		width: 100%;
	}

	table.kop
	{
		width: 100%;
	}
	table.kop td { text-align: center; }
	
	table.ttd td { text-align: center; }
	table.ttd td.left { text-align: left;  }
	table.ttd td div
	{
		display: inline-block;
		width: auto;
		border-bottom: 1px solid black;
		padding-bottom: 3px;
	}
</style>
    <page orientation="landscape" format="F4" style="font-size: 8pt">
        
<table class="kop">
        <col style="width:10%">
        <col style="width:80%">
        <col style="width:10%">
        <tr>
            <td rowspan="4"><img style="float:left" alt="jombang" width="64" height="80" src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAUFBQUFBQUGBgUICAcICAsKCQkKCxEMDQwNDBEaEBMQEBMQGhcbFhUWGxcpIBwcICkvJyUnLzkzMzlHREddXX0BBQUFBQUFBQYGBQgIBwgICwoJCQoLEQwNDA0MERoQExAQExAaFxsWFRYbFykgHBwgKS8nJScvOTMzOUdER11dff/CABEIAMgAogMBIgACEQEDEQH/xAAvAAADAQEAAwEBAAAAAAAAAAAABwgGBQMECQIBAQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIQAxAAAADLt/8ANLE1lKBNZSgTWUoE1jyxxPrB5r4EyUoE1lKBNZSgTXnK3xJ8nQD6BUtNNLAAHrcHCn59lreQwPT9RYGt1Gd4p0P43Q4nbWPWNwfz+hidtiT5OgH0CpaaX0dxG59ClGute+2c5rRzU5pZ1oqWz9vRUuk7Soa8Tlfp3cqU9loogK5xO2xJ8nQD6Ba/MaIm/u5bZFeLBtzGeCmkW+jowVeqmJovBOuIJMrOaTauCXqiJe8Dhk0drDTzfPlkAfRDE79Li3tOMqeKHnvm6o87ZULsP0meU2jCNrwIEodLOlMHBoVDegOydqZ+e49NShaBPmuAfSVXsxNiWsiWaKNCNOeRiikUxZ08I7njmpiAfOXJ55WbxutwpNkNGdGtMQ8sqsXCSCNYKDRL8nM5dOxG8C10Z7GTFvI1eTiaRcM/NnA32I2Zy6Wk6oTcUdN7LN2gdZMA5NurGcJQAduR8flEsZHaHueH2fZOVxXgyiQfbrPyk+cSlv2Sd06eyAnuhpsEfps/zgms7XF9MyJV4TE7lFRZ88s7QOPPLbXz7cJjKg1i7MzlXQzySdZRSfOvP7c7R6IyZ3PW9POe+WNK1LTQVaAZlEU7KI7oev1ICS/mP2ReCWTKmH3jMd4ClcmtMgWu2Pmm4Ri/tRc41Fc4nXCEfs7VQAAep7YRjZWVQpQ8dsT2xKarj9Qo7yrFpnl5HSUYtEk/uIbmu5K3Y9Y5/VPGj9gAAAAMxpwkb26omce2omB/i7l1ne8L+jvUW5V6/wCuhT3MfuKMOFoAAAAAAAAADnT8Bw8mBtfGBpnmB0AAAAAAD//EADAQAAICAgECBQMDBAIDAAAAAAUGAwQCBwEACBESExRBEBU3FhcgJDA2ViFXJTM1/9oACAEBAAEMANLaWVdjKt8wXvE4bPParrr4Kn+ue1XXXwVP9c9quuvgqf657VddfBU/1z2q66+Cp/rntV118FT/AFz2q66+Cp/rntV118FT/XParrr4Kn+tX6CTXZFBMJK+Wjt89quuvgqf657VddfBU/1z2q66+Cp/rntV118FT/XParrr4Kn+ue1XXXwVP9c9quuvgqf657VddfBU/wBOHbciryoymKpI1nY67VPx0d/sGG1XW+fAyfoUs7+7dVDfT5nc6ufWldra+Aa+WQJVjgqEhL8jHrWFMU2jrVr+ez/x29/TtU/HR3+Nq3UoVLNy3YwgrfuSdac562v1WW7higMTDW8XN8JTShtVa7AxY4D08dxybthEdbOlcK9KhDq9iuuSrZHNlX1DhNBSDFTOtdUhUuEOpqAXDLJOZDC9NOz7BTYoZGpeqmBwBkCNNCMkFJRW6v8ADZ/47e/p2qfjo7/BoaRqpRxms+ea1TTCzvJTLbB/9EUccEWEUWGOEfT5beaIT3SZRHXiFLll2xTpxTtYvAaYVTgdmKNi0eHDudfOOwGs9Z9egLsqv0YddesV5ZlUj9lYldy5M2bIguJzDMPnx83OPjx4/TZ/47e/p2qfjo79aTYxbNKGKKqaqCAmtlajT2Zs67xPNfxMFqQISRK35PTqZ7nU4xWJaUafwG1LEFuvWswS4yQdEnReDbUbzHGclu+7tJFhTCgR7WMg0aIfqs6cuGK0eEePRDcyELtlKc927lIvnw7SHqGQ9v3NDb3kMnUxbqkcRBOfW0ueYE+t27tLnWzhcbAtnkjHUwKdbP8Ax29/TtU/HR3pjN1FsCXN3Mv6cbsk0Q0o6Fi1v0GHVTxmhor3cF0rEpTS0EGOvA9qGCzjntNxwS1nC7KuYl6lpTf0zWmyB5jOHlcSPHhOU/6P2uXW2m0WrlLSkrU4KhlWG3dQnRidevzEVEAAErI/EaIo41KXVldeWmw+hhgfK4tauYFhgWeM1oTnQG75W72ZYQy5Vr+IgkxQ7jdcRUTNBUAaOKhALY7QTFBA2HrZ/wCO3v6dqn46O9dwc81bU7DnDNzhns1kuGRQo0Hoc8wWVrWSGgVeftuB5sWRXK8uAQ/HOHjsB29JhpoESRifntBG9a7fnQUw0cK2IHmXkEE9XHHHPrb1gNltxuo5RTQ5se1P1RDrIAzYe7w+lquzl0J/wXOL1nhAbgVLMGj11I2Emzxwkxywyw4yw2Lq1Q5cUeMBTnDlv0jXsBUvOiTogR2mbDCBsCF4ma+7Vduz51tYu2eE2EfPXa9HBFri3lFaxmzPsCtsS876utyc0iYceRxUBIuuSr1p9UB6HOylKKHIjY4IkKgkfeIXJeIa20GeBqgXTSOBarplyarzN28kzJkZkNthv/jCPo8QQHX/AFeDsYVZ6jGLgH7R1oRxoYZ0voAaK6IlbmN0RuOc+uXJEF53GttfaF1q62Sl3W0eKthiX29holg1ggyUtm1OMzHbzTVrRdiLjpauF7cleWfWLrHhBjLl12v16sWtZ84rGUmRKdUN7Lek0phwLMKy2tnGcGNKmZfbJViu1OLE4QYeA2WGKxHJDJFjnGq2b+nWKslFc5p1DuCmkg1Mx5RZ+XoNjliHFYZc/wDPS/Jyy7cbjMOeGVLdfhVTqp7GLDzwzxTRRTRZ8ZYdaPkmnBN08ufGWTP7bcTdioVMIMwHTOVyBrbCYji4kzRRp+mdUSn3UJhy5Y2py9wzwwUs89km6Z7QJA1dretx128WPQ1DXn+5e762dgD2urYbJWMsa5SzTWoCzBbI3oC5LScBKo5bOjJWMJrlav75/blVqeGYcXKaLEG4eKpN7crtPetWrT1MSrQQ8RQYebHDDjnPLLJhlNbDfzKNXZZBYNdWAikNwGBKOFWrap0yNO5Su18J69zCLVmw0cKGNTwL3Wjf8WPdAtNmlWpzQXtnkqFEUxttbaQRSrOllgqkaFQqPv0Lkfq1ri3+3jfEKb+bmAoWqhnJ9qLYExwNq7xoVRmlGKhWw8kHWjscpNHh48MfHJMojTKwKvImUo90QLfN0/YkIFq0UWvH9ahjaTB5toUrGwbemtiheRxR2CRz6h2XeP3iKcYvVCRXuC/FpXrcZYtTGKIsWcnGWIM9cafC8UuSFIRA690lmXiWoljPRxQ+5thHWuYHKH7tTgu6u3SH4gyypFcNKc3KghrW7hKe1zpH0sVMzzFNzlm6uR8+dnQ0PPnEogIYjXYKMWMx80hkpAEDFy1jzcwhRzmUkVHLDBdJMLkANvJehBhyKwovLFabe2u6YuxZ4W6FQ7lRpZRG+cI9JEeBGjRBPmtLPxYI0VAnntPW9jm4BWNeFHlhD1xY7CGXVGulkQw7MDlY6pgjylpPwlBOgu9Nc1LEk4DXvMGe3NpfqFZJrGSkQGEbDpshqLcz1avvTpDWu2ytya7fVTlm1+0mzP8ASCnX7SbM/wBIKdRa22oHkxvQKRutNVLbRjn+4Wk5jgYtVvl1RWLFI2iNud4xBpRryuH2ZENj7K1q3VElCkXWx9mOtlqdH9CzV4pkvb3VmFKbqYA3cJQUl2lfuyQi0axfoGNpLNJQ0IfEVPGXpfGjJAITPMZBlnoaDK1pQDBx4eKPjI11CIoUPmGPmsHayo80PZEZrpnWliE087iYqefjR62+kpuKCwWsVehDZ2isB4we3Tt3Ctlc625l4uHGHq5Z8w2J6/MnoT5x81DRehXyr0ylqvDrc4y3dhIkPBcjN0zNBvhkP8UDxbCmmjq+SPp9iyuk8i2vdbpuw0AWZN0iE0o2hUFDqA+nD6dZhOUlkIVM3svLXXAhplPiSDescsUV+TBDeyhBaRLg3PeVysS0myXqufngWv8AHAHXb1+Ilbo2chcmPJyQ70gRxq4WWB7jJMJPkfBSmOobPqk6SEyYC+dzS14ss7urHiDl52LZblEiLHazd8ZnooyMiy6CaGs3DGW4iu46tNbvp5qrWew7ExMNgtTUzeNX9tdi/wCgsPV5dYBsmMV0HfrSassfpzYCwVKVrMNMrDORKFbdSCzYgTnFfoIOpxFu3zDa1BtDXylrtcCGWmGqR53bq3xj45boMeTu2NMsIcmGvtlaWqvXHNz4mhiaLN3kDnscjbKhqV+uTqbsoRCtHHh0OeeUS1/jgDrtzuw3NThocOM/PawXITLWoNoKK2M2ItNimcs4msLbGuuWwuT6In8/qKaM2VBUrwsPmYeyBWz7+mNtYfZHsIN5JlTQuIpCJ2ydP2z5gizWwpNuMiZJ/IKrVZssb6jDWFwjbMsEta0sWYIXfjHGSKyzRZ2pdiYck45YneDGpacIIMwkYJuwEjQm3TNuWnWlciuHOZq3eNVfZ7RHQk2i9sSCpZ4u7JDh6IcuyS3aWVJ6ws1Q2qFbHGqx4DHmhc0XbFCyB8FBnDaz7jrvs9UmIfT83KuBLSrS7ngJs5Y9qtvOBbbRFjD0ptwYkzbbEBlULJGqtr3MrotLJQ3ZxEav08PaWd2oFJs4KdOXXNdAV+RaBDYahODKuWA9Yy0nKZChCmxuU8M7C9qp/wDbNq/7jZeudZs/hj5dwMmOUutWHwg5i24z4c56waPncLLz1+2bV/3Gy9ftm1f9xsvTYmBR1b2bzuUjKMJQIHAWcejrjNBTVcta0mGWkyq40pU2QA5TGZEMgW7yFJT+y1qmpEoz1grnr2SR1Ka+OihvtQ/dCT5wUV4FFx57a8IsA18EI4m5sYp2VlL7j2wPYym9o/rBIlMAYgMfGZrZTZEXF1ghkFYxPrLC8R38jtIh4dCbjGpXV65Rr8+14xCNgWpPJXrkBhGRZU9hYhxqnPEWx3AkwcUcDFi8EsOG3zBSacNrMXMXnzPbhiq5WLLG5Q9V2LahK5PLidc+KaJtJjoGI1/YFGxR6Lbg1mE8nNxxoZ9bDyxZSTY7XRRINUo6SUfdQ3WGW+xkdx0Ko7UbJUHRQUYFDWYg1NeLMI4s02yQisIiwcLY83krxxxwRRxR4Y4YO1bh57hFUDjbw9r13HBrIudMf6GGPNoffGNYCveo2+ZaEId/lZS6AVbA1+W6ubFSFxwWTSvhgq226CiIF53w3ml0MaJp8ICgyWv6IopADlzKyUHQ38SGhkmeLiEZeMhodfavoa6uMdmmbvXcfps3WpFzLrRUfcF+NLVbBhlNHO++yqC9OI4whSKWK9suUNng66NmImCUFKm/HWjaCJPUD66PYUAhl9nyzlGPZP8AUubbR21JmIGiSHLIYKU1sGRKWcecKfbgGkMzt2wyM2Gd/pwXKzcrnQFjnHjHt1Zb9DA1rw/HnCU2QDViq5NeYprVWN2sc3b1gxQ2gHu3TTTUOIFbAiqiuThtwrMxvWANaxK0cCJMeJqy3CRCCpWNbzqQDZya+rESA5w2LsIXTK55Og3m7fcWLOMnaZD7fhwu1b5dYZ7qdtNq5wA7gbZ+avAxxDGeh+3adbOnXcF2+tz07VMhVr2qVuGxW32xSR5qq5SpZTzLZdTaiL6fnusC1WEiAGwjmp7Bjie3kHXwa7XzgDBqdCHfrNcKZhNags4sySqv01ZdDgaXHHofTeqreVjojai3hFxZVmYQ6AB5kZJjNWMhm7U/JuyoL1Qyu7HdKLKUgxHI9cUWE21GJ+W7SsrXyhh1sEc6pC7fLVWFmaTl99DBpCMk0zYOQ2APcu81j4wZUrk1XkS0i7J0bj1gdEqaVEFTtsQ83Di4x0lcIOqh47w+DaBgoz82L5XKgLRj+fF3AsgTYDpyzOL2ObZiRGoerncLbIbvUzA1ZnpPqSpFoCNtpaOa+TA0tAlPB3jRWXnCpohYvsBc1tBh8+d/63adUjSt0bcGE1YQRKdvD1OEJczSpEcmEseGceWOWDXeuDFVlv05Yo7QMiYNa/t2kY5PG4H8Kj+SDOhYZbXKGp9eQNEMV9fL4hhYfT+ug8XOP6Xp37Gz6UPGr3OnCOq5wJQ+gW1mlUiFGC3VLaXQr02N4eMzBX3BPXkG9gJc64m9WMK5pcL2g5AnF7YyHw10AV3vBiufq7qe1DWimnsS4RxFLefcO+fZ60OeClUpVaFOrUqQYQVv4OiUAews4gvX5zwSmoxpwxVQHrP/AMVs5zpszfUTK4gieHc4TPjTVVTaLknG8NXtL/sWUUZaqpWka0s66wNYsiMUvWaSHv8A5LY4xMlDDCJ3JDTGrHW+OuwW6oAyLT9bplhhvYDMG3dpqxj6CuO+3VUzRrO+84HX+5PWwWxmx9cP99VGrVI/JjNXgPMotsTy7me1M5wVoz6YSuTQ8ujU07uZbiUkzYYgE1QFJACkEFwcYRfybk4C6g7Qc1W9aAdc2FoC5BXM5WDqE8njTCwrrdqizgRmUFYYmAaYYbhz6XWw9e65sQ32cxYmAzQL8FYaYKNzHcWg5GQfwSFXEQncZq2tQSBPWzYgRKU9a6f1HJmHQ3B/njPpLbOgLrY07F8RhHmJ77ibfEntOF1LV1gInh6YgNT4hp/2J68VmGWCxFhLCf0QVXCeTFqwzmKuht+E1m7EE2esWRdwE1rTNHlmDP07/F+fZl1jun2LVt4lYb9b1RusnJlbyWdpqLafoF1darQWftrPVAbiyYhxQaq1gptjdVdRq5TnjlOnlY3g0u9vMTq5TnsTgNCcXDErDsU7mxFIoYoI8IoY8cMP7ZEULM1c6ZMbVu1mDtrW5iGBFWPXgFmpD3Mo+WXm9mz0n/cjkcUS62W1hdG2a269nMkvEK5qGz4/pnuQarnomGqBfor/AG3pAyXO0bsXD9seMGiKmFIYOr06v8//xABFEAACAgEDAgMEBwUDCgcBAAACAwEEEQAFEhMxISJBBhAUMhUjM1Fzs9MgQlJhcSQwcjRjdIGRkpOytNIWJVR1goOiw//aAAgBAQANPwBO5tqAFVqgDgCgPJQYF6nr8dH6Wvx0fpa/HR+lr8dH6Wvx0fpa/HR+lr8dH6Wvx0fpa/HR+lq5FnmFdyhVHSeauxLLX46P0tfjo/S1+Oj9LX46P0tfjo/S1+Oj9LX46P0tfjo/S1Q22zZUDXJICNS5KOQiofd9Pu/IT/ccIZAWHgBkJTxyIFOZHOj5Y6ANsdvv6IFpRXIYtgMgQ5PN0ZPhw8RLR+AJB4cz/wAMdy/uPoK9+SXu+n3fkJ/ZrrNrmMLiCwCOREU+gjGhOVxvm55rbXGO5gQ/WOj0wOuRYpbQX0fTCC4YjyxzZIyOcnoTIxa5XxLBkoxP1j+R41VqsdOFipZNxgIKBxkinECPee0a2ywdPdkWELETPl1FlwHwxxmNGBjn4UAMBOOM8DGBIC/nExMaCPqAVYO3UHuPnrWpYJx5tCf1+5bLLepWUMDk31WQRSPeSJeimR6iv3JHvBCXiE/ymIn9n6Cvfkl7vp935Cf2HMFNOkmOb7Lz+RS4/iLHfsOhMHVfZpZQVSsYetkh/wAoPQCIiIxxERDsMR7ksEjqXOf1qvXpcTCOY6rX0Fu+0q2x1W3JVmg7ovGw1khIyOr1ZY7rX3BJurvajIrdkSAlyIzgsaFRQreEV30+u4cfYA82EwPfEDzaAyVa5AjP1VtI+BiWfn1VWLH7c44Pmo+z6zB8HK9CmOxagczHv+gr35Je76fd+Qn37Xc6Fq+MhZ3C16fVJLIoUWC4meqH0XQqbldszcfz+GzZGTKS1TQx7j7zAKHlOI9S+6PXRBBDdLarEVuJeAl1MYwWnrFijj5SA45RP+z3Utrr7JW2ukuH2Ldk5myeIDkeB8oZmMQetyqi3a91qWPiqAWRnKlWHAJQvz6s0wk1h2Bo+Uw/+JR7tvuHVtkui81qNXzyRiOMDqzLOk7gYc+kcgXgyBLvGNOKzdDfB5jZqJSGCWiQkSInaOn8S32it7m76SgyQcQdhLwJZoxxkgyM62+z8Lamm8HocXTFoWEkEl9WwSyPu+gr35Je76fd+QnVCqbziJjJcIzADykY5FPgOqCrVZ3h8K1J2J+oLAwOCwccNWZRAWXAldNHS/zhlljcHkV63B1q291rHVsNa4vrz4+EdQYiRjVy2FC1Xa3oKhdkCgpaXBkcOwzGm0+rtqfjZtsql1xwoZwMcCHX0PRzX8fqPqR8nm/h93tK5X07uYBzNCnnADz/AIyOD1vZEvb7dgcfC3z71C8ccHDGRj1PQsNgpApIQJpyZceUlgcz27R7rHt3uJ7supcQi6yQOCiB6/kiBxBapXW0Qr4WMCYYYch0SYEiUnqrtxI3J+3CDGDCrAvAXqIwlicj/QNVAJHUo3yp3dyRuIB9R03eBxzjBjplSoZ1OsCgF3MyEA6k90gXA/d9BXvyS930+78hOpbTgseom8de3m1qpWq8gU2DubPbjDREPCZLwAdbuDduROYsiq/iBYARkRiEkWqVBFciVGAklhAlI/4p8dbptxWnpZdRUjo8yHARYjDDHhJaQZfAV5epzK9UnBgDNIiBkOvgUcxGcjBcI7Tgc+6xSo9a7FlaWIsqSBrNXWNYEGOEEBYLVXdq13d7qG12m81lI8ACmzADg/fc9vb0XwoHBtOkZ4ZCMwOk7ebUV7ygCCUqcEfMS8SKfEtEOJiYzExrcr7W2TokaFzTqrk38MeAOLT6Z7fS2D2k2xNl9m11W4Fpnhg85LPk+TVzarTob8VFkKtujZ6Ta4T84iIMXyHRbaa8lASOG4Ao8xrjJROB9zd6sG4OOOifTWPDUBCqxNjn1T6fXhgD/m5HJaoHuD7m+PkBq7RTuP8AhulE46nxTjq+TGC4HqptNq4N/cakJVaQR8E/AILxQgZLkLO56qpN724meC1xyKcD49o1t39p2jd6W0P+EnqnAtUcsgSOMB6DI6t0kgSTEwgz6wjBgJePA+46+Crflx7gsXt5sqM56sTTXAIKMT25t0+pc2r7AJBJqD4lGCL5PkLjj30fbDcBlGcJljGglWMfuDy1u6ldY5TIDUSEYGuryf8AE92zWPitqs9wE+xKb3iQOO+kXH2bSN23K4tAufEjwp16a2ZjhAwLOXhE5HUIBAVBM+YCbJNzgAx8iTLELj0DUbfJ4JYNwKyhkzhkjHlgfc3d7J2BkJCFHwAOI/x+QdP3QLuy7+oulaC50EpQkCHTjqxdphgrJXOoa2AR/VjId2kycyATA6TTVs21dvr1oaRueMDH2RH4LnTBICEo5QUH3iY+7V8xjYdzIM9Cy85L4SyYgMZPTGVA/qBPHQ1Ex/8AiPdsG2p2RJSMFJWWn13EE944fIWth3zbd0XLM45IfA9h/kemAJjMesF29z/arcy8AgP34z21sDlWd5vSMybX5nFJU+XAlHc49237bbtQuZxzlCpZjPp21vwDf+PsbcB7luh2g+Ls1xMJLoikIwOrG0P3T2T3WqA1rEnT5vOpzWRS6v0o8/PV/aqLZBWViL3sDhI5zOAP3IdfOUf+l4HJdDw7Z+fW1KAN7odngPoeR78PQ/UNVmy1NdAmCXsfh7rF9wmz6hfKQ4AXUOdfC+zjT6QdJYdSoRwoAwOACMCOr9obWxnS3WaiJpZ8gIWHkhvoUHrkEzVs7rDlHI+pCYFpLdvUgF4AQEHgIwI47DqBxJTjlP8APw1tu3A663azErNg3kIklrC+xx/BGgMjkYkpIjLuZmXic/zmdPWS2IYPIGAY8ZEo9Y1vZXYftNk+aKxAOeaWMzIjn9z3f+J91/MjXUMxSNOvnJT3M8ectVFvLfpLbkJCrHR+pEnAOSMi1brsruX/ABraMjMf7J0rnUoXm2rSs1DdJGdb4cCjpEB4enVSoeTQ62piqxQXWCuF7icHY6s8lxHAA9S1VTtqEh3wCrKRH3GjcogY7yXXbr2e2VE2YJfBG6LLJMrvyfnEmBI6u3EFZC7IfBvPqS8juARrE0hAEfD1PjGt73g71ancaus9dPpgqtzDPqoIkdL5FTuhcSTa5lraa0OHdaTBfXuVx4xz5/xxJ4LU26P/AFIa3v2mpba19fAvis/lByvXDqmtrcvfIDx6nD5zMuOiWYzfujloyXqlY6M8/FJWpFhP9BCBAx0IdToH9Xcq+MZL0YvxjBSOvZ/2it7fUi1MdVdJQh0M+vAtF7RbrJxI8eJdWfAdBj6W3cowrbFlgsDmMG09FwO3a7HZdwgSPBSXAfDwCNUKb7TeEci4JCTnGt9Emy3djHo7ahGWKq0ATHUE8HPULQbYd/2e3ypZmLqbypCecRn7A84KAgtORUXZgwgJ66L4IaWB7ZINShcgH0v0+I8fCOOPL/TVGtuljoqjLG9J7T4BHqRauEI7/sgFAMrG+eeDjgfSDnowLdN3uWg6i6gXDkkAQEWGD0xg1x3OT1Su0RIrdYXRCmo6qmjzHwM5IuWv9AT/ANmjzX6qFUqzjHMFjHMSwWjZWPheYhfHpMF3jHU0/qfDEt4WSqdyn4BAzwX5IxzwR+vLTfFjnLMzL08SLX4E6/AnSPMLkJYLA9PDhoK4Qne6NZ4Od0oysbyuBLsR2EpnBas7lauu+F2lhKjrznA8pHWTKy2zte41pKB7tMqcEGrdfml9Xc76Oa2//aJDnj4jp/Vl6fpjcOB9bMnzHr4nlnzaVurQ2W1O4FTXS2y5jm2q0pGOqElxsBqAs1a/R3he4VKdUrEE9sj0coSXcZ5QZnpQ0isWCz1LNhlxRMcclJTki0VGvJFKwzMyuP5aYrcQgp9Odlo69mdqhMlyiF7sirM1yq26xQIeATAZLW7b5t9O7tMgIOBFVbUJrwdjwwckMZjHTgdW9yobcrl88s2xHBhY7cCk/L7uFdSLNeslTlG2wIjg+H3lktB7RbdS29peRwmpCyZAz6iQN+T3K2fZxmS/0FRaYBLPgUjyAu4ljuJfdopKSUpxgEyUcZmYGfujUb1SyHXafk5wLPXtwzy1G42fhgO23mKupPCCxPfGtx9qFotvm/bIWqGw4eBD1OA+C9X7VtwCzc7TYQC7JqBY5PE4AeOqiF164c5LgtQwIDkvGfCPXVCsyw2BKIIuEcuA8pEeZdhjPjOtxoTYK7cfWnbNrQ/64F00cC6plEAJs1SQD93pVjUVO/tQHIFaUoWDC2hwyMasI216jxjmDbSSEsFr6OrflxrN3/q26EzW/bXmARdBWA6tYzgQYf8AEudPYTt03Ckma5KlaZY4MCHlsFAFBRjxPVsNwTtns5tyge2snowKiyUjB2nSeTPMHoJLMjtnMMZ8k8+Y+JasnWIGN2gulhTwd3Ey9A1vHtIrclk3bnKAEghS/PAZ5nzV8mkxya59B6lhH3kRDiNFS2tYEyg4c8a4VRPt2YYeTX/tln/s1I5gH1mLKYzI5wQ/fExqtZInt6Jlxggkc4GM6dccYNlU8igjmcl3xP8ALOtq9o5t30NqWS6Sga8xPK/8cY1Wi11kyl+QlrzP0DR8eEklwxMffkg1cQaWx0HF4FHcchqxsjfZ9MIUJsYIukxQ/wAR6fUVEn1z17RUlUF3LaTrWam3U8p+OOt2gXA0unmcs1Tr7ZWXJzkuCrKR19HVvy41Us3EM5DIjknE7/WOD0jfn3/jW8Ezt1TeJFi3qMfHgLpITPMcNKu0d2m485CLCV4Qa5PtLjHAsmMnMDBajf7NwrZWWExRcIKTGByaFAZ8EwPeB0PMDuM2fc7plIYI1TFp4xwHn5ZgB0lQO3ISTvOxvfk5HplWpn0zx1YIRVx0NfMqON4pOQZ/J0vEwL7yhuh2eKrQ3OpulRcGDjYIz8CHnYMFoi6DDz7TAueJQXAtV3ROax+0+RnvOCEC4FpCyKzw332pXxEO8kBJKQ14KbXPfvaMx7SXVAxWJD34lqIsxaRT3jfIWBvHIkUmnyGMzJDwgoItHlQi7dUI9YEClzqJAI+GSktA5onSHdbrF2uafGTt3FnU58+0AEBpSCFAWdxRYukLTwXCaNfqHx0VO/bvv2xz78VKNECIjbX3JfMD7CJ5jnrcKbWtvjbUu1VMVc5sECDJktsZ+QYPV4B3ehvPPm7caJmQD1yKBnqV5yJ/cWrtmnX+7hxdDv8A+ei22qQlCzxMSodU926pB2aJNXAF+VpO1Ffp39tHF+sHOEPARMyCyBZiDXpt6zTAGkdZ1b4sOMjKGcui10SPpITOtsO3TrA7wa2wOQg/DjJdDMEwdbw6tVrDuSLh17ThOEuNJ85EhHtgS0BdA/Zzdr1rZ6TwVkZKjcqn0oAfAQDW9GpAIuWOoNiVTwAFWWBY6g57TJ6/onWPHPS7/wC5qAwySJR8p+8fKONQWfDoxr+idf0To+DXbfcclfxK1Hz44GOZeI/uasSHO0F9207ZYgu8PPcpIGQQl2lRaAVhG6bYbrS6kvbIrC50QShs4L7RY6O+2tVpb5eZZrAtqJE8Gck6AyMQUcsZLUP3q1a2e7Vs07OVJLn155uE66JnAdgzI62GhuXxFplcFxbv7jjrBWWUlKxE/P1dbnumUogCIzBA+OMevIx1t9CtUh3Dh1OguF88c5xnGvaHr2FcswBm3+2CY/xcPOGthexqqxH0ouV2jxdV6v7ksjsc6220wAv2sI3AUYDgq8HTw77hZBRM45SOtvbd3VtiwXTU0/qusJkPGWScwuOnr2K281WKpnPO8bZF+5AAFxkSr9fV+uqyobCuYGDRhgFwZHh4TnxjI6o+247igFAsDZQ6A8KyT6gzPUOciGrUt6aN2oPqeCu/1hB0/wDYWgBLLW71FRbCqDS8IBfYmaj5wj2PoP8AXHcWa5jJJT7IVETg5nKglzSkcdhOeWnJa2ju15C6JMBEZP4mOXDUzEYrEVvvGe1cT1tWyJRsF65zoPLcVOkx6QFoFCEu3WyblwXGefBecQJTpEVpCEhClr/tYMIhgdUqaHI3C7an4fczeo3dKoLuMdHzxgzL5tIA626+ym63LJvQKnQrroEjKHLHMSQHkdCIiIjHGIEewjGvZ+sm5bAxPHMSiwQYLvLMh7tmvoBw49APrKIi+4T1uNXIsQ01nwaOCwY8TAx7ekjOqYE3Zk+0NALI3qxZODU4h5kY8cHrdCIpsUDKymm5EiQ28jLHQjIRJQzVyj7UhatAJeG6bt5CIOU4wKul8n7h69rh/wDI2m2S6R1cr6B8/AeeR4amuCYr2wF1cBA5PmIHBRBznzF66zmU0L5wuSLv5HdSI5a3Qq2Yt8CIBrhMDkxiMlki9+2JsLKvudX4pDOvjx4aZVFEJ9n9pq7S4OBAUYsednDy+I6qnlV3c7TLBwUevCZ4d5zHl0HdrSwOccuMfeXh5RjxnVl1Sz8S0kLNtbnBjIL55Mi1TpWdrDZNz2sifCRZBIfIp5AkjjgJMfp221dhuW3rTPCo1wOt22imBjCTV4RygclrbqpvYK4jPBcZwMeWPTA63K46qAD2DmUOaXuu1DWBznAN7rPw/hOInGtlaxtZZ9+jPzhH8hIsjraym4q/TKQtVDH99RjBTolSpr68XKFq2DRgCEw4dEYx82JHOqMPxYppQSbyW0zrE0DTBQDq8SBmvvEBGtmjbV1Qs8GAbesA1LDunOM8DyU8fA50HzusMFQR/WS8NJgZPc7UfR9HzzxgQY7xMtUBrfF09g23rrQFoYYqx1rndRBPz62V4UL80d4q7c6HNOcD8KhRf78lra91uoYe4FT3UbRVQgs1zZA+Q8jIlJaNHXbU3enO1uhaIgmCL0mSIbw8S56dwELTxh23HJduFoPJpy4NT0mJrMZ9RIfCY1N5G72S5gBCiqyAEQ5yIyZmeBjXP4C2d/dTo5d5PHhnCDr9hwXYtbrt25Vb8NMwO9G1ZFL3muR5noyGSCqgEwRYxyLjHmn+c63x6YuZz9UvnlY6o1hVmB4c57mePvMpyXvoPWO5hPY/HANLtmCzwPVoe2PEDHymBQUdxnVywNr4NicntbDbHUwKY5sSQ9vUNTZgrxqJxxePy9KOgwAHHrgg0G0iStoID4Vt3NnOOqToGehVA+Il6cB1stkVbxG5VTiptKyj561PGHATJ4daRLVW+VGaQqPqPqPiXIlahjHkKSHW4bPSQbd9eNCHp3Otk4GCz9gY+aNbxS29k7iNe420p6OBNr44DEqIxzqfaCzbNfwlmuDqz1QgIabE4mREckE+TW37hfe/cNsuL3KtaY0gXDcJ5SkeIQI89XtyI9wWvLgmjiAGoSiE1sBK8wsZDV+5elfshbeZ1biEDyJ4SPIa7e0Dz4jqtWVS2bYNuqNfbQ2scPmw/wDcnz+BBqtIVRANuY8rzCAEusWuusUox/GOrKfhkprzlFCnnnFcPAcny8TPVUMlASPNhegBBSMSZeka3FzQoi4CkgAsD1AMv+GOOwfsWksS5ZdjW2OJCX+KJ1uryeqz0pLpEQYyOJLzh2PRQMiQzmJj741V2229LG/Zgxa5IZL+WY0ZlZ9pktnF/cPHrLfWZ3wuIwIDp+z2I3bcaxpJL2qE1QKiyPN7scCTPn1VaebiSS3fLBHzTJS3H9igg7AGijLrW4hFxzj9TOXcoyWkbM/ppOIBYCgOQyEDBYJeMhGm7BtvNFhcMUXFIEOQLSi5ovbOwqbl/fwEPJrcweFTf6osVepy8Pt7FNJiDREtBt3XFwW+Na5T+3Aaxl9oLD+UYifPp1tRgncTA330XJUJ0rLDHM9EI+29ywJjGHOAEBjMyUl2HWwkcncW7pNbLcD1IyJxOePkHVdQqQoI4gABHERGP4Rj9mfFLoxDkH6GBek6cwvojfCkuj0sfIXLsH/JqlVTuVyltgkXxbvA0qazt0OJiRTrbNmHcts3OhuCXvQlboQKwlIDELLlPk1tBCe7XKYwoEm1hEdcAEBHrn3MtK8DitANvqAh8SJJRweAlqEi0t22+DchQ+vxavFiOPbnOQ03YNwlVhJiYHhRDPGY0jZduSz4melIsGuOVYLx56sVz+B3PckN615p4FcbdVESkyLlEiRae2XGLMzuLxLIiByfggB0iPjqVdwxCwBhgI2apunK+8Qeq60fS1quhb69VdxZNirVBnioBgsjIYMtey6Bah18Phn/AEdwgo64FjBV4mAI48uqvGb96Dwt0ZgZNheoCXgID8+kxEtPHne7EcnH/Mv22eKzHwNLB7GovQh0He1WRBtqyQyI4Ejjo+f0PIav7c3YrtiuqWnUBroNUvAvsfvEz0mJkmljqOYXczkYHJF7lq/te6UHfDGQZ7GIwQmRT/KSnW71bR0Ogo6tndWnwIWtork1dLzeIBI6r1hK3ftwO67tTETxJV6FrhAjwgY6nDTzkWbpuDPibYF88qyUD0fnyQR7tnk7Wz2FnwIX4+yIv4GYwcTret3sWkbd2st6QirCVsKS0PKBtSuGvsdKfkz4EzJ+g4DSY/qZn6mc+pF/ctAgYBjBAUF4FBQXeNABZoPbzSfhjgBMgu/3M1Cv8vQuZW37jIP09CpZmCHAZgLe3MInIf0mInSi6Hs9twvW2hSk8/XPAZLmf3s1coLZZtv+uXXb1BIK9YB4wAlMCGtk26kitvVUZhkHWARweOMmHk0DQ+mdyncBihucDEjl9Vecz/MNQHIVEzLT+/pLHznoBmW373EQAe2RDR8S6EZiqP8AyyYjoRxAjGIj/V/eF3VZSDQn17FGNCXMYAicsDEswS/ETDSQyaydDiIBjMyJF0nEer4KCHvBkiMEwcfVOV4kWMCWjiQB1o2kkGCMn52ECQ04SYfwhBzVBTmFB0fPMj/M9FnlNlkgvP38A0HKQRXUKVhznlPEBgY7/wBx/8QAFBEBAAAAAAAAAAAAAAAAAAAAcP/aAAgBAgEBPwAP/8QAFBEBAAAAAAAAAAAAAAAAAAAAcP/aAAgBAwEBPwAP/9k=">
            
            </td>
            <td><strong style="font-size: 11pt;">PEMERINTAH KABUPATEN JOMBANG</strong></td>
            <td rowspan="4">    <table align="right" style="padding: 5px 20px; border: solid 1px black;">
        <tr><td><strong style="font-size: 16pt;">F-1.01</strong></td></tr>
    </table></td>
        </tr>
        <tr>
            <td class="center"><strong style="font-size: 11pt;">DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</strong></td>
        </tr>
        <tr>
            <td class="center"><i style="font-size: 9pt;">Jl. KH. Wahid Hasyim No. 137 Jombang Telp. (0321) 861229 Kode Pos 61411</i></td>
        </tr>
        <tr>
            <td class="center"><strong style="font-size: 11pt;">J O M B A N G</strong></td>
        </tr>
    </table>
    <hr>
    <p style="text-align: center; margin-top: 10px; margin-bottom: 0px; padding-bottom: 0px;">
        <strong style="font-size: 12pt;">FORMULIR BIODATA KELUARGA</strong>
    </p>
    <table class="disdukcapil" style="margin-top: 0px; border: 0px;">
        <col span="48" style="width: 2.0833%;">

        <tr><td colspan="48">&nbsp;</td></tr>
        <tr>
            <td colspan="48" class="hitam kotak left"><b style="color:white;">PERHATIAN: Isilah Formulir ini dengan huruf cetak dan jelas serta mengikuti "TATA CARA PENGISIAN FORMULIR"</b></td>
        </tr>

        <tr><td colspan="48">&nbsp;</td></tr>
        <tr>
            <td colspan="48">Pilih salah satu:</td>
        </tr>
        <tr>
            <td class="tengah kotak">V</td>
            <td colspan="46">&nbsp;&nbsp;&nbsp;Input Data Kepala Keluarga dan Anggota Keluarga WNI</td>
        </tr>
        <tr>
            <td class="kotak">&nbsp;</td>
            <td colspan="46">&nbsp;&nbsp;&nbsp;Input Data Kepala Keluarga dan Anggota Keluarga Orang Asing</td>
        </tr>
        <tr>
            <td class="kotak">&nbsp;</td>
            <td colspan="46">&nbsp;&nbsp;&nbsp;Input Data Kepala Keluarga dan Anggota Keluarga WNI di luar Negeri</td>
        </tr>
        <tr><td colspan="48">&nbsp;</td></tr>

        <tr>
            <td colspan="48"><strong>DATA KEPALA KELUARGA</strong></td>
        </tr>
        <tr>
            <td>1.</td>
            <td colspan="16">Nama Kepala Keluarga/<i>Name of Head of Family</i></td>
            <td class="kanan"> : </td>
            <td colspan="28" class="kotak"><?= $individu['kepala_kk']?></td>
            <td colspan="2"></td>
        </tr>
        <?php
            $dusun          = ($this->setting->sebutan_dusun == '-') ? '' : ucwords(strtolower($this->setting->sebutan_dusun)) . ' ' . ucwords(strtolower($data['dusun']));
            $alamat_wilayah = "{$kepala_keluarga['alamat']} RT {$kepala_keluarga['rt']} / RW {$kepala_keluarga['rw']} " . $dusun;
            $alamat_wilayah = trim($alamat_wilayah);
        ?>
        <tr>
            <td>2.</td>
            <td colspan="16">Alamat/<i>Addres</i></td>
            <td class="kanan"> : </td>
            <td colspan="28" class="kotak" ><?= $individu['alamat']; ?> Dusun <?= $individu['dusun'] ?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="16"></td>
            <td class="kanan"></td>
            <td colspan="28" class="kotak">&nbsp;</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>3.</td>
            <td colspan="16">Kode Pos/<i>Post Code</i></td>
            <td class="kanan"> : </td>
            <?php for ($i=0; $i<5; $i++): ?>
                <td class="kotak padat tengah">
                    <?= $config['kode_pos'][$i] ?: '&nbsp;' ?>
                </td>
            <?php endfor; ?>
            <td colspan="2"></td>
            <td colspan="2" class="kanan">4. RT</td>
            <?php for ($i=0; $i<3; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($kepala_keluarga['rt'][$i])): ?>
                        <?= $kepala_keluarga['rt'][$i];?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td colspan="3" class="kanan">5. RW</td>
            <?php for ($i = 0; $i < 3; $i++) : ?>
                <td class="kotak satu">
                    <?php if (isset($kepala_keluarga['rw'][$i])) : ?>
                        <?= $kepala_keluarga['rw'][$i] ?>
                    <?php else : ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td colspan="7" class="kanan">6. Jumlah Anggota Keluarga</td>
            <?php for ($i=0; $i<2; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($individu['jumlah_anggota'][$i])): ?>
                        <?= $individu['jumlah_anggota'][$i];?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td colspan="2">Orang</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>7.</td>
            <td colspan="16">Telepon/<i>Telephone Number/Handphone</i></td>
            <td class="kanan"> : </td>
            <?php for ($i=0; $i<16; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($kepala_keluarga['telepon'][$i])): ?>
                        <?= $kepala_keluarga['telepon'][$i] ?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td colspan="13"></td>
        </tr>
        <tr>
            <td>8.</td>
            <td colspan="16">Email</td>
            <td class="kanan"> : </td>
            <td colspan="17" class="kotak"><?= $kepala_keluarga['email'] ?></td>
            <td colspan="13"></td>
        </tr>

        <tr><td colspan="48">&nbsp;</td></tr>
        <tr>
            <td colspan="48">Kode Wilayah diisi oleh Petugas Kependudukan dan Pencatatan Sipil</td>
        </tr>
        <tr>
            <td colspan="48"><strong>DATA WILAYAH</strong></td>
        </tr>
        <tr>
            <td>9.</td>
            <td colspan="16">Kode-Nama Provinsi/<i>Code-Province</i></td>
            <td class="kanan"> : </td>
            <?php for ($i=0; $i<2; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($config['kode_propinsi'][$i])): ?>
                        <?= $config['kode_propinsi'][$i] ?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td colspan="3"></td>
            <td colspan="23" class="kotak"><?= $config['nama_propinsi'] ?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>10.</td>
            <td colspan="16">Kode-Nama Kabupaten/Kota/<i>Code-Regency/Municipality</i></td>
            <td class="kanan"> : </td>
            <?php for ($i=0; $i<2; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($config['kode_kabupaten'][$i])): ?>
                        <?= substr($config['kode_kabupaten'], 2, 4)[$i]; ?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td colspan="3"></td>
            <td colspan="23" class="kotak"><?= $config['nama_kabupaten'] ?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>11.</td>
            <td colspan="16">Kode-Nama Kecamatan/<i>Code-Sub-District</i></td>
            <td class="kanan"> : </td>
            <?php for ($i=0; $i<2; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($config['kode_kecamatan'][$i])): ?>
                        <?= substr($config['kode_kecamatan'], 4, 6)[$i]; ?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td colspan="3"></td>
            <td colspan="23" class="kotak"><?= $config['nama_kecamatan'] ?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>12.</td>
            <td colspan="16">Kode-Nama Kelurahan/Desa/<i>Code-Village</i></td>
            <td class="kanan"> : </td>
            <?php for ($i=0; $i<4; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($config['kode_desa'][$i])): ?>
                        <?= substr($config['kode_desa'], 6, 10)[$i]; ?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td></td>
            <td colspan="23" class="kotak"><?= $config['nama_desa'] ?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>13.</td>
            <td colspan="16">Nama Dusun/Kampung/<i>Sub-Village</i></td>
            <td class="kanan"> : </td>
            <td colspan="28" class="kotak"><?= $individu['dusun'] ?></td>
            <td colspan="2"></td>
        </tr>

        <tr><td colspan="48">&nbsp;</td></tr>
        <tr>
            <td colspan="48"><b>Alamat di Luar Negeri (diisi oleh WNI di luar negeri)</b></td>
        </tr>
        <tr>
            <td>1.</td>
            <td colspan="8">Alamat</td>
            <td class="kanan"> : </td>
            <td colspan="36" class="kotak">&nbsp;</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="8"></td>
            <td class="kanan"></td>
            <td colspan="36" class="kotak">&nbsp;</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>2.</td>
            <td colspan="8">Kota</td>
            <td class="kanan"> : </td>
            <td colspan="15" class="kotak">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>3.</td>
            <td colspan="4">Provinsi / Negara Bagian</td>
            <td class="kanan"> : </td>
            <td colspan="13" class="kotak">&nbsp;</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>4.</td>
            <td colspan="8">Negara</td>
            <td class="kanan"> : </td>
            <td colspan="36" class="kotak">&nbsp;</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>5.</td>
            <td colspan="8">Kode Pos</td>
            <td class="kanan"> : </td>
            <td colspan="15" class="kotak">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>6.</td>
            <td colspan="6">Jumlah Anggota Keluarga</td>
            <td class="kanan"> : </td>
            <?php for ($i=0; $i<2; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($config['jumlah_anggota'][$i])): ?>
                        <?= substr($config['jumlah_anggota'], 4, 6)[$i] ?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td colspan="10">Orang</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>7.</td>
            <td colspan="8">Telepone / Handphone</td>
            <td class="kanan"> : </td>
            <?php for ($i=0; $i<13; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($config['telephone'][$i])): ?>
                        <?= substr($config['telephone'], 4, 6)[$i] ?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td colspan="2"></td>
        </tr>

        <tr><td colspan="48">&nbsp;</td></tr>
        <tr>
            <td colspan="48"><i>Diisi oleh Petugas</i></td>
        </tr>
        <tr>
            <td colspan="9">Kode - Nama Negara</td>
            <td class="kanan"> : </td>
            <?php for ($i=0; $i<3; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($config['kode_negara'][$i])): ?>
                        <?= substr($config['kode_negara'], 4, 6)[$i] ?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td></td>
            <td colspan="32" class="kotak"></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="9">Kode - Nama Perwakilan RI</td>
            <td class="kanan"> : </td>
            <?php for ($i=0; $i<3; $i++): ?>
                <td class="kotak padat tengah">
                    <?php if (isset($config['kode_negara'][$i])): ?>
                        <?= substr($config['kode_negara'], 4, 6)[$i] ?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td></td>
            <td colspan="32" class="kotak"></td>
            <td colspan="2"></td>
        </tr>

        <tr><td colspan="48">&nbsp;</td></tr>

        <tr>
            <td colspan="48"><strong>DATA ANGGOTA KELUARGA</strong></td>
        </tr>
        <tr>
            <td colspan="48">Catatan :</td>
        </tr>
        <tr>
            <td colspan="48">&nbsp;&nbsp;&nbsp;- Bagi Penduduk WNI mengisi Kolom 2 s.d 6, 10 s.d 31, 38 s.d 41</td>
        </tr>
        <tr>
            <td colspan="48">&nbsp;&nbsp;&nbsp;- <i>For Foreigners only, please fill column 2 to 13, 15 to 41</i></td>
        </tr>
        <tr>
            <td colspan="48">&nbsp;&nbsp;&nbsp;- Bagi WNI di luar wilayah NKRI mengisi nomor 2 s.d 31, 38 s.d 41</td>
        </tr>
    </table>

    <!-- 1 sampai 7-->
    <?php $kolom = 7 ?>
    <table style="border-collapse: collapse;" class="disdukcapil">
        <col style="width: 2%;">
        <col style="width: 30%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 28%;">

        <tr>
            <td class="judul tengah" rowspan="2">No.</td>
            <td class="judul tengah" rowspan="2">Nama Lengkap <br><i>Full Name</i></td>
            <td class="judul tengah" colspan="2">Gelar</td>
            <td class="judul tengah" rowspan="2">Nomor Paspor <br><i>Passport Number</i></td>
            <td class="judul tengah" rowspan="2">Tanggal Berakhir Paspor <br><i>Date of Expiry</i></td>
            <td class="judul tengah" rowspan="2">Nama Sponsor <br><i>Sponsor Name</i></td>
        </tr>
        <tr>
            <td class="judul tengah">Depan</td>
            <td class="judul tengah">Belakang</td>
        </tr>
        <tr>
            <?php for ($i=0; $i<$kolom; $i++): ?>
                <td class="judul abu tengah"><?= $i + 1 ?></td>
            <?php endfor; ?>
        </tr>
        <?php for ($i=0; $i<MAX_ANGGOTA_F101; $i++): ?>
            <tr>
                <?php $class = ($i==10-1) ? "bawah" : "anggota";?>
                <td class="tengah <?= $class?>"><?= $i+1; ?></td>
                <?php if ($i < count($anggota)): ?>
                    <td class="tengah <?= $class?>"><?= $anggota[$i]['nama'] ?></td>
                    <td class="tengah <?= $class?>">-</td>
                    <td class="tengah <?= $class?>">-</td>
                    <td class="tengah <?= $class?>"><?= $anggota[$i]['dokumen_pasport'] ?: '-' ?></td>
                    <td class="tengah <?= $class?>"><?= tgl_indo_out($anggota[$i]['tanggal_akhir_paspor']) ?: '-' ?></td>
                    <td class="tengah <?= $class?>">-</td>
                <?php else: ?>
                    <?php for ($k=0; $k<$kolom-1; $k++): ?>
                        <td class="tengah <?= $class ?>">&nbsp;</td>
                    <?php endfor; ?>
                <?php endif; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <!-- 8 sampai 15-->
    <br /><br />
    <?php $kolom = 9; $mulai = 8; ?>
    <table style="border-collapse: collapse;" class="disdukcapil">
        <col style="width: 2%;">
        <col style="width: 8%;">
        <col style="width: 18%;">
        <col style="width: 8%;">
        <col style="width: 18%;">
        <col style="width: 18%;">
        <col style="width: 12%;">
        <col style="width: 8%;">
        <col style="width: 8%;">

        <tr>
            <td class="judul tengah">No.</td>
            <td class="judul tengah">Tipe Sponsor <br /><i>Type of Sponsor</i></td>
            <td class="judul tengah">Alamat Sponsor <br /><i>Sponsor Address</i></td>
            <td class="judul tengah">Jenis Kelamin <br /><i>Sex</i></td>
            <td class="judul tengah">Tempat Lahir <br /><i>Place of Birth</i></td>
            <td class="judul tengah">Tanggal, Bulan, Tahun Lahir <br /><i>Date of Birth</i></td>
            <td class="judul tengah">Kewarganegaraan <br /><i>Nationaly</i></td>
            <td class="judul tengah">No. SK <br />Penetapan WNI</td>
            <td class="judul tengah">Akta Lahir</td>
        </tr>
        <tr>
            <td class="judul abu tengah">&nbsp;</td>
            <?php for ($i=$mulai; $i<$kolom + ($mulai - 1); $i++): ?>
                <td class="judul abu tengah"><?= $i ?></td>
            <?php endfor; ?>
        </tr>
        <?php for ($i=0; $i<MAX_ANGGOTA_F101; $i++): ?>
            <tr>
                <?php $class = ($i==10-1) ? "bawah" : "anggota";?>
                <td class="tengah <?= $class ?>"><?= $i+1; ?></td>
                <?php if ($i < count($anggota)): ?>
                    <td class="tengah <?= $class ?>">-</td>
                    <td class="tengah <?= $class ?>">-</td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['sex'] ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['tempatlahir'] ?></td>
                    <td class="tengah <?= $class ?>"><?= tgl_indo_out($anggota[$i]['tanggallahir']) ?: '' ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['warganegara'] ?></td>
                    <td class="tengah <?= $class ?>">-</td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['akta_lahir'] ? '2' : '1' ?></td>
                <?php else: ?>
                    <?php for ($k=1; $k<$kolom; $k++): ?>
                        <td class="tengah <?= $class ?>">&nbsp;</td>
                    <?php endfor; ?>
                <?php endif; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <!-- 16 sampai 23-->
    <br /><br />
    <?php $kolom = 9; $mulai = 16; ?>
    <table style="border-collapse: collapse;" class="disdukcapil">
        <col style="width: 2%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 8%;">
        <col style="width: 20%;">
        <col style="width: 14%;">
        <col style="width: 8%;">
        <col style="width: 14%;">
        <col style="width: 14%;">

        <tr>
            <td class="judul tengah">No.</td>
            <td class="judul tengah">Nomor Akta Kelahiran</td>
            <td class="judul tengah">Gol. Darah <br /><i>Type of Blood</i></td>
            <td class="judul tengah">Agama <br /><i>Religion</i></td>
            <td class="judul tengah">Nama Organisasi Kepercayaan terhadap Tuhan YME</td>
            <td class="judul tengah">Status Perkawinan <br /><i>Matial Status</i></td>
            <td class="judul tengah">Akta Perkawinan</td>
            <td class="judul tengah">Nomor Akta Perkawinan</td>
            <td class="judul tengah">Tanggal Perkawinan</td>
        </tr>
        <tr>
            <td class="judul abu tengah">&nbsp;</td>
            <?php for ($i=$mulai; $i<$kolom + ($mulai - 1); $i++): ?>
                <td class="judul abu tengah"><?= $i ?></td>
            <?php endfor; ?>
        </tr>
        <?php for ($i=0; $i<MAX_ANGGOTA_F101; $i++): ?>
            <tr>
                <?php $class = ($i==10-1) ? "bawah" : "anggota";?>
                <td class="tengah <?= $class ?>"><?= $i+1; ?></td>
                <?php if ($i < count($anggota)): ?>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['akta_lahir'] ?: '-' ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['golongan_darah'] ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['agama'] ?></td>
                    <td class="tengah <?= $class ?>">-</td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['status_kawin'] ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['akta_perkawinan'] ? '2' : '1' ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['akta_perkawinan'] ?: '-' ?></td>
                    <td class="tengah <?= $class ?>"><?= tgl_indo_out($anggota[$i]['tanggalperkawinan']) ?: '' ?></td>
                <?php else: ?>
                    <?php for ($k=1; $k<$kolom; $k++): ?>
                        <td class="tengah <?= $class ?>">&nbsp;</td>
                    <?php endfor; ?>
                <?php endif; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <!-- 24 sampai 33-->
    <br /><br />
    <?php $kolom = 11; $mulai = 24; ?>
    <table style="border-collapse: collapse;" class="disdukcapil">
        <col style="width: 2%;">
        <col style="width: 8%;">
        <col style="width: 8%;">
        <col style="width: 8%;">
        <col style="width: 12%;">
        <col style="width: 8%;">
        <col style="width: 7%;">
        <col style="width: 16%;">
        <col style="width: 16%;">
        <col style="width: 7%;">
        <col style="width: 8%;">

        <tr>
            <td class="judul tengah">No.</td>
            <td class="judul tengah">Akta Cerai</td>
            <td class="judul tengah">Nomor Akta Perceraian</td>
            <td class="judul tengah">Tanggal Perceraian</td>
            <td class="judul tengah">Status Hubungan <br /> Dalam Keluarga</td>
            <td class="judul tengah">Kelainan Fisik & Mental</td>
            <td class="judul tengah">Penyandang Cacat</td>
            <td class="judul tengah">Pendidikan Terakhir</td>
            <td class="judul tengah">Jenis Pekerjaan</td>
            <td class="judul tengah">Nomor ITAS/ ITAP</td>
            <td class="judul tengah">Tempat Terbit ITAS/ ITAP</td>
        </tr>
        <tr>
            <td class="judul abu tengah"></td>
            <?php for ($i=$mulai; $i<$kolom + 23; $i++): ?>
                <td class="judul abu tengah"><?= $i ?></td>
            <?php endfor; ?>
        </tr>
        <?php for ($i=0; $i<MAX_ANGGOTA_F101; $i++): ?>
            <tr>
                <?php $class = ($i==10-1) ? "bawah" : "anggota";?>
                <td class="tengah <?= $class ?>"><?= $i+1; ?></td>
                <?php if ($i < count($anggota)): ?>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['akta_perceraian'] ? '2' : '1' ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['akta_perceraian'] ?></td>
                    <td class="tengah <?= $class ?>"><?= tgl_indo_out($anggota[$i]['tanggalperceraian']) ?: '' ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['hubungan'] ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['cacat'] ? '2' : '1' ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['cacat'] ?: '-' ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['pendidikan'] ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['pekerjaan'] ?></td>
                    <td class="tengah <?= $class ?>">-</td>
                    <td class="tengah <?= $class ?>">-</td>
                <?php else: ?>
                    <?php for ($k=1; $k<$kolom; $k++): ?>
                        <td class="tengah <?= $class ?>">&nbsp;</td>
                    <?php endfor; ?>
                <?php endif; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <!-- 34 sampai 41-->
    <br /><br />
    <?php $kolom = 9; $mulai = 34; ?>
    <table style="border-collapse: collapse;" class="disdukcapil">
        <col style="width: 2%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 14%;">
        <col style="width: 15%;">
        <col style="width: 14%;">
        <col style="width: 15%;">

        <tr>
            <td class="judul tengah">No.</td>
            <td class="judul tengah">Tanggal Terbit ITAS/ ITAP</td>
            <td class="judul tengah">Tanggal Akhir ITAS/ ITAP</td>
            <td class="judul tengah">Tempat Datang <br /> Pertama</td>
            <td class="judul tengah">Tanggal Kedatangan Pertama</td>
            <td class="judul tengah">NIK Ibu</td>
            <td class="judul tengah">Nama Ibu</td>
            <td class="judul tengah">NIK Ayah</td>
            <td class="judul tengah">Nama Ayah</td>
        </tr>
        <tr>
            <td class="judul abu tengah"></td>
            <?php for ($i=$mulai; $i<$kolom + ($mulai - 1); $i++): ?>
                <td class="judul abu tengah"><?= $i ?></td>
            <?php endfor; ?>
        </tr>
        <?php for ($i=0; $i<MAX_ANGGOTA_F101; $i++): ?>
            <tr>
                <?php $class = ($i==10-1) ? "bawah" : "anggota";?>
                <td class="tengah <?= $class ?>"><?= $i+1; ?></td>
                <?php if ($i < count($anggota)): ?>
                    <td class="tengah <?= $class ?>">-</td>
                    <td class="tengah <?= $class ?>">-</td>
                    <td class="tengah <?= $class ?>">-</td>
                    <td class="tengah <?= $class ?>">-</td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['ibu_nik'] ?: '-' ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['nama_ibu'] ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['ayah_nik'] ?: '-' ?></td>
                    <td class="tengah <?= $class ?>"><?= $anggota[$i]['nama_ayah'] ?></td>
                <?php else: ?>
                    <?php for ($k=1; $k<$kolom; $k++): ?>
                        <td class="tengah <?= $class ?>">&nbsp;</td>
                    <?php endfor; ?>
                <?php endif; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <table class="ttd" style="margin-top: 15px">
        <col style="width:10%">
        <col style="width:30%">
        <col style="width:20%">
        <col style="width:30%">
        <col style="width:10%">

        <tr>
            <td>&nbsp;</td>
            <td class="center">Mengetahui,</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="center">Kepala Dinas Kependudukan dan Pencatatan Sipil</td>
            <td>&nbsp;</td>
            <td class="center">Kepala Keluarga/<i>Head of Family</i></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="center">Kabupaten <?= $config['nama_kabupaten'] ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr><td colspan="7" style="height: 20px;">&nbsp;</td></tr>
        <tr>
            <td>&nbsp;</td>
            <td class="center"><div><?= str_pad("", 390,"&nbsp;")?></div></td>
            <td>&nbsp;</td>
            <td class="center">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="center"><br/><?= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NIP.".str_pad("",390,"&nbsp;") ?></td>
            <td>&nbsp;</td>
            <td class="center"><td class="center"><?= $kepala_keluarga['nama'] ?></td></td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <br />
        <br />
            <br />
                <br />
    <p style="margin-top: 0px;">
        PERNYATAAN<br>
        Demikian Formulir ini saya/kami isi dengan sesungguhnya. Apabila keterangan tersebut tidak sesuai dengan sebenarnya, <br />
        saya bersedia dikenakan sanksi sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.
    </p>
</page>