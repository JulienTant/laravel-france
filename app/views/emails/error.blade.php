<div>
    Message :<br />
    <pre>
        {{ print_r($exception->getMessage(), true) }}
    </pre>
</div>

<div>
    Code :<br />
    <pre>
        {{ print_r($exception->getCode(), true) }}
    </pre>
</div>

<div>
    File :<br />
    <pre>
        {{ print_r($exception->getFile(), true) }}
    </pre>
</div>

<div>
    Line :<br />
    <pre>
        {{ print_r($exception->getLine(), true) }}
    </pre>
</div>

<div>
    Trace :<br />
    <pre>
        {{ print_r($exception->getTrace(), true) }}
    </pre>
</div>

<div>
    Trace As String : <br />
    <pre>
        {{ print_r($exception->getTraceAsString(), true) }}
    </pre>
</div>
