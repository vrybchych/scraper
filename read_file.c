#define _GNU_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

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


int main(int argc, char **argv)
{
    FILE * fp;
    char * line = NULL;
    size_t len = 0;
    ssize_t read;
    int i = 0;
    int j = 0;
    char url[4096];

    if (argc != 2)
    {
	printf("Wrong arguments number\n");
	exit(0);
    }
    fp = fopen(argv[1], "r");
    if (fp == NULL)
        exit(EXIT_FAILURE);

    while ((read = getline(&line, &len, fp)) != -1) {
	if (line[0] == '-' && line[1] == '-')
            {
                strcpy(url, line + 25);
            }
            if (strstr(line, "saved"))
            {
		j = 0;
		while (line[j] != ')')
		    j++;
		j += 5;
                i = find_save(line + j) + j;
                line[i - 2] = '\0';
                printf("URL: %s", url);
                printf("SAVED: %s\n", line + j);
            }
    }

    fclose(fp);
    if (line)
        free(line);
    exit(EXIT_SUCCESS);
}
