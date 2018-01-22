#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int input(char *s,int length);

int find_save(char *s)
{
	int i = 0;

	while(s[i])
	{
		if (s[i] == 's' && s[i+1] == 'a' && s[i+2] == 'v' && s[i+3] == 'e')
			return(i);
		i++;
	}
	return (0);
}

int main()
{
	char	b[4096];
	char	*buffer = b;
	char	url[4096];
	size_t	bufsize = 4096;
	size_t	characters;
	int	i;

	while(getline(&buffer, &bufsize, stdin) != -1)
	{
		if (buffer[0] == '-' && buffer[1] == '-')
		{
			strcpy(url, buffer + 25);
			//printf("URL: %s", buffer + 25);
		}
		if (strstr(buffer, "saved"))
		{
			i = find_save(buffer + 35) + 35;	
			buffer[i - 4] = '\0';
			
			printf("URL: %s", url);
			printf("SAVED: %s\n", buffer + 37);
		}		
	}

    return(0);
}
